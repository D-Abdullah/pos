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
use App\Models\Purchase;
use App\Models\Rent;
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

            $parties = $parties->with('client')->paginate(PAGINATION);
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
            $party = Party::with('client')->findOrFail($id);
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
            $party = Party::findOrFail($id);

            // logic
            foreach ($request->input('bill') as $bill) {
                $billDB = new Bill();
                // rent
                if ($bill['from'] == 'rent') {
                    $rent = Rent::findOrFail($bill['rent_id']);

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
                        $rent->update([
                            "party_id" => $party->id,
                            "party_qty" => $bill['quantity'],
                        ]);
                        WarehouseTransaction::create([
                            'product_id' => null,
                            'rent_id' => $rent->id,
                            'quantity' => $bill['quantity'],
                            'from' => "مخزن الإيجار",
                            'to' => "الحفله " . $party->name,
                            'type' => 'party_rent',
                        ]);
                    }
                    $billDB->save();
                } else if ($bill['from'] == 'product') {
                    $product = Product::findOrFail($bill['product_id']);

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
                    }

                    // werehouse transaction
                    if ($party->status === "transported" && $bill['status'] === "ready") {
                        if ($bill['type'] == 'rent') {
                            $product->update([
                                "quantity" => $product->quantity - $bill['quantity'],
                                "party_id" => $party->id,
                                "party_qty" => $bill['quantity'],
                            ]);
                            WarehouseTransaction::create([
                                'product_id' => $product->id,
                                'rent_id' => null,
                                'quantity' => $bill['quantity'],
                                'from' => "المخزن",
                                'to' => "الحفله " . $party->name,
                                'type' => 'party_rent',
                            ]);
                        } else if ($bill['type'] == 'sale') {
                            $product->update([
                                "quantity" => $product->quantity - $bill['quantity'],
                                "party_id" => $party->id,
                                "party_qty" => $bill['quantity'],
                            ]);
                            WarehouseTransaction::create([
                                'product_id' => $product->id,
                                'rent_id' => null,
                                'quantity' => $bill['quantity'],
                                'from' => "المخزن",
                                'to' => "الحفله " . $party->name,
                                'type' => 'party_sale',
                            ]);
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
                    $billDB->save();
                }
            }

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
            $party = Party::findOrFail($id);
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
            $party = Party::findOrFail($id);
            $party->update([
                'client_id' => $request->input('client_id'),
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'date' => $request->input('date'),
                'status' => $request->input('status'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            // if ($request->input('deposits')) {
            //     for ($i = 0; $i < count($request->input('deposits')); $i++) {
            //         $deposit = new Deposit();
            //         $deposit->party_id = $party->id;
            //         $deposit->type = "party";
            //         $deposit->cost = $request->input('deposits')[$i]['cost'];
            //         $deposit->date = $request->input('deposits')[$i]['date'];
            //         $deposit->save();
            //     }
            // }

            DB::commit();
            return redirect()->route('party.editBill', $party->id)
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
            $party = Party::with('client')->findOrFail($id);
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
        // return $request->all();
        try {
            DB::beginTransaction();
            $party = Party::findOrFail($id);
            // logic
            foreach ($request->input('bill') as $bill) {
                if ($bill['id']) {
                    $billDB = Bill::findOrFail($bill['id']);
                    if (count($bill) === 1 && isset($bill['id'])) {
                        $billDB->delete();
                        continue;
                    }
                } else {
                    $billDB = new Bill();
                }
                // rent
                if ($bill['from'] == 'rent') {
                    $rent = Rent::findOrFail($bill['rent_id']);

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
                        $rent->update([
                            "party_id" => $party->id,
                            "party_qty" => $bill['quantity'],
                        ]);
                        WarehouseTransaction::create([
                            'product_id' => null,
                            'rent_id' => $rent->id,
                            'quantity' => $bill['quantity'],
                            'from' => "مخزن الإيجار",
                            'to' => "الحفله " . $party->name,
                            'type' => 'party_rent',
                        ]);
                    }
                    $billDB->save();
                } else if ($bill['from'] == 'product') {
                    $product = Product::findOrFail($bill['product_id']);

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
                    }

                    // werehouse transaction
                    if ($party->status === "transported" && $bill['status'] === "ready") {
                        if ($bill['type'] == 'rent') {
                            $product->update([
                                "quantity" => $product->quantity - $bill['quantity'],
                                "party_id" => $party->id,
                                "party_qty" => $bill['quantity'],
                            ]);
                            WarehouseTransaction::create([
                                'product_id' => $product->id,
                                'rent_id' => null,
                                'quantity' => $bill['quantity'],
                                'from' => "المخزن",
                                'to' => "الحفله " . $party->name,
                                'type' => 'party_rent',
                            ]);
                        } else if ($bill['type'] == 'sale') {
                            $product->update([
                                "quantity" => $product->quantity - $bill['quantity'],
                                "party_id" => $party->id,
                                "party_qty" => $bill['quantity'],
                            ]);
                            WarehouseTransaction::create([
                                'product_id' => $product->id,
                                'rent_id' => null,
                                'quantity' => $bill['quantity'],
                                'from' => "المخزن",
                                'to' => "الحفله " . $party->name,
                                'type' => 'party_sale',
                            ]);
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
                    $billDB->save();
                }
            }

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

    public function show(Party $party)
    {
    }

    public function destroy(Party $party)
    {
    }
    public function getname(Request $request, $type)
    {

        if ($type == 'product') {
            $product = Product::where('id', $request->id)->first();
            $averagePrices = [];
            $purchases = Purchase::where('product_id', $product->id)->pluck('unit_price');
            $averagePrice = $purchases->avg();
            $averagePrices[$product->id] = $averagePrice;
            $product->avg_price = $averagePrices[$product->id] ?? 0;
            return $product;
        } else if ($type == 'rent') {
            return Rent::where('id', $request->id)->first();
        }
        return null;
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
