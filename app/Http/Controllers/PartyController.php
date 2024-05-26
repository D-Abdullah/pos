<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Deposit;
use App\Models\Party;
use App\Http\Requests\StorePartyRequest;
use App\Http\Requests\UpdatePartyRequest;
use App\Models\Client;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Eol;
use App\Models\Product;
use App\Models\ProductParty;
use App\Models\Purchase;
use App\Models\Rent;
use App\Models\RentParty;
use App\Models\Safe;
use App\Models\WarehouseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PartyController extends Controller
{
    /**
     * Party Controller Index Method
     + Show the datatable with party data and bills and warehouse data needed
     */
    public function index()
    {
        try {
            $parties = Party::query();
            $clients = Client::all();
            $readyBill = false;
            $parties = $parties->with('client', 'bills')->paginate(PAGINATION);
            foreach ($parties as $party) {
                foreach ($party->bills as $bill) {
                    if ($bill->status == "ready" && $bill->is_transfared) {
                        $readyBill = true;
                    } else {
                        $readyBill = false;
                        break;
                    }
                }
                $party->readyBill = $readyBill;
            }
            return view('pages.party.index', compact('parties', 'clients'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب الحفلات: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب الحفلات. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Party Controller Create Method
     + Show the Form For Only Party Data
     */
    public function create()
    {
        try {
            $clients = Client::all();
            $status = [
                [
                    'name' => 'متعاقد',
                    'value' => 'contracted'
                ],
                [
                    'name' => 'منقول',
                    'value' => 'transported'
                ]
            ];
            $employees = Employee::all();
            $safes = Safe::all();
            return view('pages.party.add', compact('clients', 'status', 'employees', 'safes'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب صفحه اضافه الحفله: ' . $e->getMessage());

            return redirect()->back()->with([
                'error' =>
                    'حدث خطأ أثناء جلب صفحه اضافه الحفله. يرجى المحاولة مرة أخرى.'
            ]);
        }
    }

    /**
     * Party Controller Update Method
     + Store the Form For Only Party Data
     */
    public function store(StorePartyRequest $request)
    {
        try {
            DB::beginTransaction();
            $party = Party::create([
                'client_id' => $request->input('client_id'),
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'status' => $request->input('status'),
                'added_by' => auth()->user()->getAuthIdentifier(),
                'total_price' => 0,
                'total_profit' => 0
            ]);

            $deposit = new Deposit();
            $deposit->cost = $request->input('d_cost');
            $deposit->date = $request->input('d_date');
            $deposit->type = "client";
            $deposit->client_id = $request->input('client_id');
            $deposit->supplier_id = null;
            $deposit->is_paid = $request->input('d_is_paid');
            $deposit->from = $request->input('d_from');
            $deposit->employee_id = $request->input('d_from') == 'custody' ? $request->input('d_employee_id') : null;
            $deposit->safe_id = $request->input('d_from') == 'safe' ? $request->input('d_safe_id') : null;

            $deposit->save();


            DB::commit();
            return redirect()->route('party.addBill', $party->id)
                ->with(['success' => 'تم إنشاء بيانات الحفله بنجاح, الأن قم بأضافه بيانات الفاتوره']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء اضافه بيانات الحفله: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())
                ->with(['error' => 'حدث خطأ أثناء اضافه بيانات الحفله. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Party Controller Create Method
     + Show the Form For Only Party Bill Data
     */
    public function createBill(int $id)
    {
        try {
            $party = Party::with('client')->where('id', '=', $id)->first();
            $categories = Department::all();

            return view('pages.party.addBill', compact('id', 'party', 'categories'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء عرض صفحه بيانات الفاتوره: ' . $e->getMessage());

            return redirect()->back()
                ->with(['error' => 'حدث خطأ أثناء عرض صفحه بيانات الفاتوره. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Party Controller Create Method
     + Store the Form For Only Party Bill Data
     */
    public function storeBill(Request $request, int $id)
    {
        try {
            DB::beginTransaction();
            $party = Party::where('id', '=', $id)->first();

            // logic
            foreach ($request->input('bill') as $bill) {
                $billDB = new Bill();

                // rent
                if ($bill['from'] == 'rent') {
                    $rent = Rent::where('id', '=', $bill['rent_id'])->first();

                    $billDB->from = $bill['from'];
                    $billDB->name = null;
                    $billDB->quantity = $bill['quantity'];
                    $billDB->unit_price = $bill['unit_price'];
                    $billDB->total_price = $bill['total_price'];
                    $billDB->rent_id = $rent->id;
                    $billDB->product_id = null;
                    $billDB->type = $bill['type'];
                    $billDB->status = $bill['status'];
                    $billDB->party_id = $party->id;
                    if ($party->status === "transported" && $bill['status'] === "ready") {
                        RentParty::create([
                            'rent_id' => $bill['rent_id'],
                            'party_id' => $id,
                            'quantity' => $bill['quantity'],
                            'type' => $bill['type'],
                        ]);
                        WarehouseTransaction::create([
                            'product_id' => null,
                            'rent_id' => $rent->id,
                            'quantity' => $bill['quantity'],
                            'from' => "مخزن الإيجار",
                            'to' => "الحفله " . $party->name,
                            'type' => 'party_rent_i',
                        ]);
                        $rent->update([
                            "quantity" => $rent->quantity - $bill->quantity
                        ]);
                        $billDB->purchase_price = $rent->rent_price * $bill['quantity'];
                        $billDB->profit = (float) (($bill['total_price']) - ($rent->rent_price * $bill['quantity']));
                    }
                    $billDB->save();
                } else if ($bill['from'] == 'product') {
                    $product = Product::where('id', '=', $bill['product_id'])->first();

                    $billDB->from = $bill['from'];
                    $billDB->name = null;
                    $billDB->quantity = $bill['quantity'];
                    $billDB->unit_price = $bill['unit_price'];
                    $billDB->total_price = $bill['total_price'];
                    $billDB->rent_id = null;
                    $billDB->product_id = $product->id;
                    $billDB->type = $bill['type'];
                    $billDB->status = $bill['status'];
                    $billDB->party_id = $party->id;
                    $billDB->eol_reason = $bill['eol_reason'];

                    if ($bill['type'] == 'eol') {
                        Eol::create([
                            'product_id' => $product->id,
                            'quantity' => $bill['quantity'],
                            'added_by' => Auth::user()->id,
                            'reason' => $bill['eol_reason']
                        ]);
                        $product->update([
                            'quantity' => $product->quantity - $bill['quantity'],
                        ]);
                        WarehouseTransaction::create([
                            'product_id' => $product->id,
                            'rent_id' => null,
                            'quantity' => $bill['quantity'],
                            'from' => "الحفله " . $party->name,
                            'to' => "هالك",
                            'type' => 'party_eol',
                        ]);
                        $billDB->purchase_price = $product->purchase_price * $bill['quantity'];
                        $billDB->profit = 0;
                    }

                    // werehouse transaction
                    if ($party->status === "transported" && $bill['status'] === "ready") {
                        if ($bill['type'] == 'rent') {
                            WarehouseTransaction::create([
                                'product_id' => $product->id,
                                'rent_id' => null,
                                'quantity' => $bill['quantity'],
                                'from' => "المخزن",
                                'to' => "الحفله " . $party->name,
                                'type' => 'party_rent_i',
                            ]);
                            ProductParty::create([
                                'product_id' => $bill['product_id'],
                                'party_id' => $id,
                                'quantity' => $bill['quantity'],
                                'type' => $bill['type'],
                            ]);
                            $product->update([
                                "quantity" => $product->quantity - $bill['quantity']
                            ]);
                            $billDB->purchase_price = $product->purchase_price * $bill['quantity'];
                            $billDB->profit = (float) (($bill['total_price']) - ($product->purchase_price * $bill['quantity']));
                        } else if ($bill['type'] == 'sale') {
                            $product->update([
                                "quantity" => $product->quantity - $bill['quantity'],
                            ]);
                            WarehouseTransaction::create([
                                'product_id' => $product->id,
                                'rent_id' => null,
                                'quantity' => $bill['quantity'],
                                'from' => "المخزن",
                                'to' => "الحفله " . $party->name,
                                'type' => 'party_sale',
                            ]);
                            ProductParty::create([
                                'product_id' => $bill['product_id'],
                                'party_id' => $id,
                                'quantity' => $bill['quantity'],
                                'type' => $bill['type'],
                            ]);
                            $billDB->purchase_price = $product->purchase_price * $bill['quantity'];
                            $billDB->profit = (float) (($bill['total_price']) - ($product->purchase_price * $bill['quantity']));
                        }
                    }
                    $billDB->save();
                } else if ($bill['from'] == 'custom') {
                    $billDB->from = $bill['from'];
                    $billDB->name = $bill['name'];
                    $billDB->quantity = $bill['quantity'];
                    $billDB->unit_price = $bill['unit_price'];
                    $billDB->total_price = $bill['total_price'];
                    $billDB->rent_id = null;
                    $billDB->product_id = null;
                    $billDB->type = $bill['type'];
                    $billDB->status = $bill['status'];
                    $billDB->party_id = $party->id;
                    $billDB->purchase_price = 0;
                    $billDB->profit = (float) $bill['total_price'];
                    $billDB->save();
                }
            }
            $P_total_price = 0;
            $p_total_profit = 0;
            $p_bills = Bill::where('party_id', '=', $id)->get();
            foreach ($p_bills as $bill) {
                $P_total_price += $bill->total_price;
                $p_total_profit += $bill->profit;
            }
            $party->update([
                'total_price' => $P_total_price,
                'total_profit' => $p_total_profit
            ]);
            DB::commit();
            return redirect()->route('party.all')
                ->with(['success' => 'تم إنشاء فاتورة الحفله بنجاح']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء اضافه بيانات الحفله: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())
                ->with(['error' => 'حدث خطأ أثناء اضافه بيانات الحفله. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function edit($id)
    {
        try {

            $party = Party::where('id', '=', $id)->with('bills', 'client')->first();
            $clients = Client::all();
            $status = [
                [
                    'name' => 'متعاقد',
                    'value' => 'contracted'
                ],
                [
                    'name' => 'منقول',
                    'value' => 'transported'
                ]
            ];
            return view('pages.party.edit', compact('clients', 'status', 'party'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب صفحه تعديل الحفله: ' . $e->getMessage());

            return redirect()->back()->with([
                'error' =>
                    'حدث خطأ أثناء جلب صفحه تعديل الحفله. يرجى المحاولة مرة أخرى.'
            ]);
        }
    }

    public function update(UpdatePartyRequest $request, $id)
    {
        try {

            DB::beginTransaction();
            $party = Party::where('id', '=', $id)->first();
            $party->update([
                'client_id' => $request->input('client_id'),
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'status' => $request->input('status'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            DB::commit();
            return redirect()->route('party.editBill', $id)
                ->with(['success' => 'تم تعديل بيانات الحفله بنجاح, الأن قم بأضافه بيانات الفاتوره']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تعديل بيانات الحفله: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())
                ->with(['error' => 'حدث خطأ أثناء تعديل بيانات الحفله. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function editBill($id)
    {
        try {
            $party = Party::with('client')->where('id', '=', $id)->first();
            $bills = Bill::where("party_id", $id)->with("product", "rent")->get();
            $categories = Department::all();
            return view('pages.party.editBill', compact('id', 'party', 'categories', 'bills'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء عرض صفحه تعديل بيانات الفاتوره: ' . $e->getMessage());

            return redirect()->back()
                ->with(['error' => 'حدث خطأ أثناء عرض صفحه تعديل بيانات الفاتوره. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function updateBill(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $party = Party::where('id', '=', $id)->first();

            // logic
            foreach ($request->input('bill') as $bill) {
                if (isset($bill['id'])) {
                    $billDB = Bill::where('id', '=', $bill['id'])->first();
                    if (count($bill) === 1) {
                        $billDB->delete();
                        continue;
                    }
                } else {
                    $billDB = new Bill();
                }
                // rent
                if ($bill['from'] == 'rent') {
                    $rent = Rent::where('id', '=', $bill['rent_id'])->first();

                    $billDB->from = $bill['from'];
                    $billDB->name = null;
                    $billDB->quantity = $bill['quantity'];
                    $billDB->unit_price = $bill['unit_price'];
                    $billDB->total_price = $bill['total_price'];
                    $billDB->rent_id = $rent->id;
                    $billDB->product_id = null;
                    $billDB->type = $bill['type'];
                    $billDB->party_id = $id;
                    if ($party->status === "transported" && $bill['status'] === "ready") {
                        if (!$billDB->is_transfared) {
                            RentParty::create([
                                'rent_id' => $bill['rent_id'],
                                'party_id' => $id,
                                'quantity' => $bill['quantity'],
                                'type' => $bill['type'],
                            ]);
                            WarehouseTransaction::create([
                                'product_id' => null,
                                'rent_id' => $rent->id,
                                'quantity' => $bill['quantity'],
                                'from' => "مخزن الإيجار",
                                'to' => "الحفله " . $party->name,
                                'type' => 'party_rent_i',
                            ]);
                            $rent->update([
                                "quantity" => $rent->quantity - $bill['quantity'],
                            ]);
                            $billDB->purchase_price = $rent->rent_price * $bill['quantity'];
                            $billDB->profit = (float) (($bill['total_price']) - ($rent->rent_price * $bill['quantity']));
                            $billDB->is_transfared = true;
                        }
                    }
                    $billDB->status = $bill['status'];
                    $billDB->save();
                } else if ($bill['from'] == 'product') {
                    $product = Product::where('id', '=', $bill['product_id'])->first();

                    $billDB->from = $bill['from'];
                    $billDB->name = null;
                    $billDB->quantity = $bill['quantity'];
                    $billDB->unit_price = $bill['unit_price'];
                    $billDB->total_price = $bill['total_price'];
                    $billDB->rent_id = null;
                    $billDB->product_id = $product->id;
                    $billDB->type = $bill['type'];
                    $billDB->party_id = $party->id;
                    $billDB->eol_reason = $bill['eol_reason'];

                    if ($bill['type'] == 'eol') {
                        if (!$billDB->is_transfared) {
                            Eol::create([
                                'product_id' => $product->id,
                                'quantity' => $bill['quantity'],
                                'added_by' => Auth::user()->id,
                                'reason' => $bill['eol_reason']
                            ]);
                            $product->update([
                                'quantity' => $product->quantity - $bill['quantity'],
                            ]);
                            WarehouseTransaction::create([
                                'product_id' => $product->id,
                                'rent_id' => null,
                                'quantity' => $bill['quantity'],
                                'from' => "الحفله " . $party->name,
                                'to' => "هالك",
                                'type' => 'party_eol',
                            ]);
                            $billDB->purchase_price = $product->purchase_price * $bill['quantity'];
                            $billDB->profit = 0;
                            $billDB->is_transfared = true;
                        }
                    }

                    // werehouse transaction
                    if ($party->status === "transported" && $bill['status'] === "ready") {
                        if (!$billDB->is_transfared) {
                            if ($bill['type'] == 'rent') {
                                ProductParty::create([
                                    'product_id' => $bill['product_id'],
                                    'party_id' => $id,
                                    'quantity' => $bill['quantity'],
                                    'type' => $bill['type'],
                                ]);
                                WarehouseTransaction::create([
                                    'product_id' => $product->id,
                                    'rent_id' => null,
                                    'quantity' => $bill['quantity'],
                                    'from' => "المخزن",
                                    'to' => "الحفله " . $party->name,
                                    'type' => 'party_rent_i',
                                ]);
                                $product->update([
                                    "quantity" => $product->quantity - $bill['quantity']
                                ]);
                                $billDB->purchase_price = $product->purchase_price * $bill['quantity'];
                                $billDB->profit = (float) (($bill['total_price']) - ($product->purchase_price * $bill['quantity']));
                                $billDB->is_transfared = true;
                            } else if ($bill['type'] == 'sale') {
                                $product->update([
                                    "quantity" => $product->quantity - $bill['quantity'],
                                ]);
                                ProductParty::create([
                                    'product_id' => $bill['product_id'],
                                    'party_id' => $id,
                                    'quantity' => $bill['quantity'],
                                    'type' => $bill['type'],
                                ]);
                                WarehouseTransaction::create([
                                    'product_id' => $product->id,
                                    'rent_id' => null,
                                    'quantity' => $bill['quantity'],
                                    'from' => "المخزن",
                                    'to' => "الحفله " . $party->name,
                                    'type' => 'party_sale',
                                ]);
                                $billDB->purchase_price = $product->purchase_price * $bill['quantity'];
                                $billDB->profit = (float) (($bill['total_price']) - ($product->purchase_price * $bill['quantity']));
                                $billDB->is_transfared = true;
                            }
                        } else {
                            if (isset($bill['id'])) {
                                $billRecord = Bill::where('id', '=', $bill['id'])->first();
                                if ($bill['type'] == 'rent') {
                                    ProductParty::where('party_id', $id)
                                        ->where('quantity', $billRecord->quantity)
                                        ->where('product_id', $product->id)
                                        ->where('type', $billRecord->type)
                                        ->update([
                                            'quantity' => $bill['quantity'],
                                        ]);

                                    if ($bill['quantity'] > $billRecord->quantity) {
                                        // +
                                        WarehouseTransaction::create([
                                            'product_id' => $product->id,
                                            'rent_id' => null,
                                            'quantity' => abs((int) intval($bill['quantity'] - $billRecord->quantity)),
                                            'from' => "المخزن",
                                            'to' => "الحفله " . $party->name,
                                            'type' => 'party_rent_i',
                                        ]);
                                        // -
                                        $product->update([
                                            "quantity" => $product->quantity - abs((int) intval($bill['quantity'] - $billRecord->quantity))
                                        ]);
                                    } else if ($bill['quantity'] < $billRecord->quantity) {
                                        // -
                                        WarehouseTransaction::create([
                                            'product_id' => $product->id,
                                            'rent_id' => null,
                                            'quantity' => abs((int) intval($billRecord->quantity - $bill['quantity'])),
                                            'from' => "الحفله " . $party->name,
                                            'to' => "المخزن",
                                            'type' => 'party_rent_o',
                                        ]);
                                        // +
                                        $product->update([
                                            "quantity" => $product->quantity + abs((int) intval($billRecord->quantity - $bill['quantity'])),
                                        ]);
                                    }
                                    $billDB->purchase_price = $product->purchase_price * $bill['quantity'];
                                    $billDB->profit = (float) (($bill['total_price']) - ($product->purchase_price * $bill['quantity']));
                                    $billDB->is_transfared = true;
                                } else if ($bill['type'] == 'sale') {
                                    ProductParty::where('party_id', $id)
                                        ->where('quantity', $billRecord->quantity)
                                        ->where('product_id', $product->id)
                                        ->where('type', $billRecord->type)
                                        ->update([
                                            'quantity' => $bill['quantity'],
                                        ]);

                                    if ($bill['quantity'] > $billRecord->quantity) {
                                        // +
                                        WarehouseTransaction::create([
                                            'product_id' => $product->id,
                                            'rent_id' => null,
                                            'quantity' => abs((int) intval($bill['quantity'] - $billRecord->quantity)),
                                            'from' => "المخزن",
                                            'to' => "الحفله " . $party->name,
                                            'type' => 'party_sale',
                                        ]);
                                        // -
                                        $product->update([
                                            "quantity" => $product->quantity - abs((int) intval($bill['quantity'] - $billRecord->quantity))
                                        ]);
                                    } else if ($bill['quantity'] < $billRecord->quantity) {
                                        // -
                                        WarehouseTransaction::create([
                                            'product_id' => $product->id,
                                            'rent_id' => null,
                                            'quantity' => abs((int) intval($billRecord->quantity - $bill['quantity'])),
                                            'from' => "الحفله " . $party->name,
                                            'to' => "المخزن",
                                            'type' => 'party_sale',
                                        ]);
                                        // +
                                        $product->update([
                                            "quantity" => $product->quantity + abs((int) intval($billRecord->quantity - $bill['quantity'])),
                                        ]);
                                    }
                                    $billDB->purchase_price = $product->purchase_price * $bill['quantity'];
                                    $billDB->profit = (float) (($bill['total_price']) - ($product->purchase_price * $bill['quantity']));
                                    $billDB->is_transfared = true;
                                }
                            }
                        }
                    }
                    $billDB->status = $bill['status'];
                    $billDB->save();
                } else if ($bill['from'] == 'custom') {
                    $billDB->from = $bill['from'];
                    $billDB->name = $bill['name'];
                    $billDB->quantity = $bill['quantity'];
                    $billDB->unit_price = $bill['unit_price'];
                    $billDB->total_price = $bill['total_price'];
                    $billDB->rent_id = null;
                    $billDB->product_id = null;
                    $billDB->type = $bill['type'];
                    $billDB->status = $bill['status'];
                    $billDB->party_id = $party->id;
                    $billDB->purchase_price = 0;
                    $billDB->profit = (float) $bill['total_price'];
                    $billDB->is_transfared = true;
                    $billDB->save();
                }
            }
            $P_total_price = 0;
            $p_total_profit = 0;
            $p_bills = Bill::where('party_id', '=', $id)->get();
            foreach ($p_bills as $bill) {
                $P_total_price += $bill->total_price;
                $p_total_profit += $bill->profit;
            }
            $party->update([
                'total_price' => $P_total_price,
                'total_profit' => $p_total_profit
            ]);
            DB::commit();
            return redirect()->route('party.all')
                ->with(['success' => 'تم تعديل فاتورة الحفله بنجاح']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تعديل بيانات الحفله: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())
                ->with(['error' => 'حدث خطأ أثناء تعديل بيانات الحفله. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function complete($id)
    {
        try {
            DB::beginTransaction();
            $party = Party::where('id', '=', $id)->with('client', 'bills')->first();
            // all rent back to store
            if ($party->status == "transported") {
                foreach ($party->bills as $bill) {
                    if ($bill->type == "rent") {
                        if ($bill->from == "rent") {
                            $rent = Rent::where('id', '=', $bill->rent_id)->first();
                            WarehouseTransaction::create([
                                'product_id' => null,
                                'rent_id' => $rent->id,
                                'quantity' => $bill->quantity,
                                'from' => "الحفله " . $party->name,
                                'to' => "مخزن الإيجار",
                                'type' => 'party_rent_o',
                            ]);
                            $rent->update([
                                "quantity" => $rent->quantity + $bill->quantity
                            ]);
                            RentParty::where('party_id', $party->id)
                                ->where('quantity', $bill->quantity)
                                ->where('rent_id', $rent->id)
                                ->where('type', $bill->type)
                                ->delete();
                        } else if ($bill->from == "product") {
                            $product = Product::where('id', '=', $bill->product_id)->first();
                            WarehouseTransaction::create([
                                'product_id' => $product->id,
                                'rent_id' => null,
                                'quantity' => $bill['quantity'],
                                'from' => "الحفله " . $party->name,
                                'to' => "المخزن",
                                'type' => 'party_rent_o',
                            ]);
                            ProductParty::where('party_id', $party->id)
                                ->where('quantity', $bill->quantity)
                                ->where('product_id', $product->id)
                                ->where('type', $bill->type)
                                ->delete();
                            $product->update([
                                "quantity" => $product->quantity + $bill['quantity']
                            ]);
                        }
                    }
                }
                // finish the party
                $party->status = "completed";
                $party->save();
                DB::commit();
                return redirect()->route('party.all')
                    ->with(['success' => 'تم إنهاء الحفله بنجاح']);
            } else {
                return redirect()->back()
                    ->with(['error' => 'لا يمكن انهاء الحفله لان الحفله لازالت في حاله التعاقد']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء انهاء الحفله: ' . $e->getMessage());

            return redirect()->back()
                ->with(['error' => 'حدث خطأ أثناء انهاء الحفله. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function destroy($id)
    {
        try {
            $party = Party::where('id', '=', $id)->with('bills', 'client')->first();
            $delete = false;
            if ($party->status == "transported") {
                if (count($party->bills) > 0) {
                    foreach ($party->bills as $bill) {
                        if ($bill->status == "ready" && $bill->is_transfared) {
                            return redirect()->back()
                                ->with(['error' => 'لا يمكن حذف هذه الحفله بسبب تعبئة بيانات الفاتورة']);
                        } else {
                            $delete = true;
                        }
                    }
                }
            } else {
                $delete = true;
            }

            if ($delete == true) {
                foreach ($party->bills as $bill) {
                    $bill->delete();
                }
                $party->delete();
                return redirect()->route('party.all')
                    ->with(['success' => 'تم حذف الحفله بنجاح']);
            }

        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف الحفله: ' . $e->getMessage());

            return redirect()->back()
                ->with(['error' => 'حدث خطأ أثناء حذف الحفله. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function getData(Request $request, $type)
    {
        // request parameters is (type, name, department, id, page)
        try {
            $rules = [
                'id' => 'nullable|numeric',
                'name' => 'nullable|string',
                'department' => 'nullable|exists:departments,id',
            ];

            $request->validate($rules);
            if ($type == 'product') {
                $products = Product::query();

                if ($request->filled('name')) {
                    $searchTerm = trim($request->input('name'));
                    $products->where(function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('description', 'like', '%' . $searchTerm . '%');
                    });
                }
                if ($request->filled('department')) {
                    $products->where('department_id', $request->input('department'));
                }
                if ($request->filled('id')) {
                    $products->where('id', $request->input('id'));
                }
                $data = $products->with('department')->paginate(PAGINATION);
            } else if ($type == 'rent') {
                $rent = Rent::query();

                if ($request->filled('name')) {
                    $searchTerm = trim($request->input('name'));
                    $rent->where(function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');
                    });
                }
                if ($request->filled('id')) {
                    $rent->where('id', $request->input('id'));
                }
                $data = $rent->paginate(PAGINATION);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب المنتجات: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب المنتجات. يرجى المحاولة مرة أخرى.']);
        }
    }
}
