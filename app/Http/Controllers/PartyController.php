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
                ],
                [
                    'name' => 'منتهي',
                    'value' => 'completed'
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
            $products = Product::all();
            $rents = Rent::all();
            $categories = Department::all();

            // Initialize an array to store average unit prices for each product
            $averagePrices = [];

            // Loop through each product to calculate average unit price
            foreach ($products as $product) {
                // Fetch all purchases for the current product
                $purchases = Purchase::where('product_id', $product->id)->pluck('unit_price');

                // Calculate the average unit price for the current product
                $averagePrice = $purchases->avg();

                // Add the average price to the array
                $averagePrices[$product->id] = $averagePrice;
            }

            // Now, add a new item to each product with the calculated average price
            foreach ($products as $product) {
                $product->avg_price = $averagePrices[$product->id] ?? 0;
            }

            return view('pages.party.addBill', compact('id', 'products', 'rents', 'party', 'categories'));
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
                    $billDB->unit_price = $rent->sale_price;
                    $billDB->total_price = $rent->sale_price * $bill['quantity'];
                    $billDB->rent_id = $bill['rent_id'];
                    $billDB->product_id = null;
                    $billDB->type = 'rent';
                    $billDB->status = $bill['status'];
                    $billDB->party_id = $party->id;
                    if ($party->status === "transported" && $bill['status'] === "ready") {
                        $rent->update([
                            "party_id" => $party->id,
                            "party_qty" => $bill['quantity'],
                        ]);
                    }
                    $billDB->save();
                } else if ($bill['from'] == 'items') {
                    $product = Product::findOrFail($bill['product_id']);
                    $averagePrices = [];
                    $purchases = Purchase::where('product_id', $product->id)->pluck('unit_price');
                    $averagePrice = $purchases->avg();
                    $averagePrices[$product->id] = $averagePrice;
                    $product->avg_price = $averagePrices[$product->id] ?? 0;
                    $billDB->from = $bill['from'];
                    $billDB->name = null;
                    $billDB->quantity = $bill['quantity'];
                    $billDB->unit_price = $product->avg_price;
                    $billDB->total_price = $product->avg_price * $bill['quantity'];
                    $billDB->rent_id = null;
                    $billDB->product_id = $bill['product_id'];
                    $billDB->type = $bill['type'];
                    $billDB->status = $bill['status'];
                    $billDB->party_id = $party->id;
                    if ($bill['type'] == 'eol') {
                        Eol::create([
                            'product_id' => $bill['product_id'],
                            'quantity' => $bill['quantity'],
                            'added_by' => Auth::user()->id,
                            'reason' => $bill['eol_ression']
                        ]);
                        Product::where('id', $bill['product_id'])->update([
                            'quantity' => $product->quantity - $bill['quantity'],
                        ]);
                    }
                    // werehouse transaction
                    if ($party->status === "transported" && $bill['status'] === "ready") {
                        if ($bill['type'] == 'rent' || $bill['type'] == 'sale') {
                            Product::where('id', $bill['product_id'])->update([
                                "quantity" => $product->quantity - $bill['quantity'],
                                "party_id" => $party->id,
                                "party_qty" => $bill['quantity'],
                            ]);
                            WarehouseTransaction::create([
                                "product_id" => $bill['product_id'],
                                "quantity" => $bill['quantity'],
                                "from" => "المخزن",
                                "to" => "الحفله " . $party->name,
                            ]);
                        }
                    }
                    $billDB->save();
                } else {
                    $billDB->from = $bill['from'];
                    $billDB->name = $bill['name'];
                    $billDB->quantity = 1;
                    $billDB->unit_price = null;
                    $billDB->total_price = $bill['total_price'];
                    $billDB->rent_id = null;
                    $billDB->product_id = null;
                    $billDB->type = 'sale';
                    $billDB->status = 'ready';
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
                ->with(['error' => 'حدث خطأ أثناء اضافه بيانات الحفله. يرجى المحاولة مرة أخرى.' . $e->getMessage()]);
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
                ],
                [
                    'name' => 'منتهي',
                    'value' => 'completed'
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

    public function editBill(Party $party)
    {
    }

    public function updateBill(UpdatePartyRequest $request, Party $party)
    {
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
}
