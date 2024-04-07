<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Deposit;
use App\Models\Party;
use App\Http\Requests\StorePartyRequest;
use App\Http\Requests\UpdatePartyRequest;
use App\Models\Client;
use App\Models\Department;
use App\Models\Eol;
use App\Models\Product;
use App\Models\Rent;
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
            return view('pages.party.add', compact('clients', 'status'));
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
        // return $request->all();
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

            if ($request->input('deposits')) {
                for ($i = 0; $i < count($request->input('deposits')); $i++) {
                    $deposit = new Deposit();
                    $deposit->party_id = $party->id;
                    $deposit->type = "party";
                    $deposit->cost = $request->input('deposits')[$i]['cost'];
                    $deposit->date = $request->input('deposits')[$i]['date'];
                    $deposit->save();
                }
            }

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
            return view('pages.party.addBill', compact('id', 'products', 'rents', 'party', 'categories'));
        } catch (\Exception $e) {
            DB::rollBack();
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
        return $request->all();
        try {
            DB::beginTransaction();
            $party = Party::findOrFail($id);

            // deposits
            if ($request->input('deposits')) {
                for ($i = 0; $i < count($request->input('deposits')); $i++) {
                    $deposit = new Deposit();
                    $deposit->party_id = $party->id;
                    $deposit->type = "party";
                    $deposit->cost = $request->input('deposits')[$i]['cost'];
                    $deposit->date = $request->input('deposits')[$i]['date'];
                    $deposit->save();
                }
            }

            $testRequest = [
                "_token" => "@csrf",
                "deposits" => [
                    [
                        "cost" => 500,
                        "date" => "2022-10-03"
                    ],
                    [
                        "cost" => 5000,
                        "date" => "2022-12-03"
                    ]
                ],
                'bills' => [
                    [
                        "party_id" => $party->id,
                        "from" => 'custom',
                        "product_id" => null,
                        "rent_id" => null,
                        "name" => "نقل الكوشه",
                        "quantity" => null,
                        "unit_price" => null,
                        "total_price" => 500,
                        "type" => null,
                        "eol_ression" => null,
                        "status" => null
                    ],
                    [
                        "party_id" => $party->id,
                        "from" => 'items',
                        "product_id" => 1,
                        "rent_id" => null,
                        "name" => null,
                        "quantity" => 16,
                        "unit_price" => 10,
                        "total_price" => 160, # unit_price * quantity
                        "type" => "sale",
                        "eol_ression" => null,
                        "status" => "preparing"
                    ],
                    [
                        "party_id" => $party->id,
                        "from" => 'items',
                        "product_id" => 1,
                        "rent_id" => null,
                        "name" => null,
                        "quantity" => 2,
                        "unit_price" => 10,
                        "total_price" => 20, # unit_price * quantity
                        "type" => "eol",
                        "eol_ression" => "eol because ...",
                        "status" => "ready"
                    ],
                    [
                        "party_id" => $party->id,
                        "from" => 'items',
                        "product_id" => 1,
                        "rent_id" => null,
                        "name" => null,
                        "quantity" => 5,
                        "unit_price" => 10,
                        "total_price" => 50, # unit_price * quantity
                        "type" => "rent",
                        "eol_ression" => null,
                        "status" => "preparing"
                    ],
                    [
                        "party_id" => $party->id,
                        "from" => 'rent',
                        "product_id" => null,
                        "rent_id" => 1,
                        "name" => null,
                        "quantity" => 10,
                        "unit_price" => 20, # take from rent data
                        "total_price" => 200, # take from rent data
                        "type" => "rent",
                        "eol_ression" => null,
                        "status" => "preparing"
                    ]
                ]
            ];

            // logic
            foreach ($testRequest['bills'] as $bill) {

                // rent
                if ($bill['from'] == 'rent') {
                    $rent = Rent::findOrFail($bill['rent_id']);
                    $bill['unit_price'] = $rent->sale_price;
                    $bill['total_price'] = $rent->sale_price * $bill['quantity'];

                    //check rent quantity is enough
                }

                // product
                if ($bill['from'] == 'items') {
                    $product = Product::findOrFail($bill['product_id']);
                    $bill['total_price'] = $bill['unit_price'] * $bill['quantity'];

                    //check product quantity is enough
                }

                // eol
                if ($bill['type'] === 'eol') {
                    $eol = Eol::create([
                        'product_id' => $bill['product_id'],
                        'quantity' => $bill['quantity'],
                        'added_by' => Auth::user()->id,
                        'reason' => $bill['eol_ression']
                    ]);
                }
                // werehouse transaction
                if ($party->status === "transported" && $bill['status'] === "ready") {
                    if ($bill['from'] === 'items') {
                        $werehouse_transaction = WarehouseTransaction::create([
                            "product_id" => $bill['product_id'],
                            "quantity" => $bill['quantity'],
                            "from" => "المخزن",
                            "to" => "الحفله " . $party->name,
                        ]);
                    }
                }

                // store bill data in database
                $bill = Bill::create([
                    "party_id" => $party->id,
                    "from" => $bill['from'],
                    "product_id" => $bill['product_id'],
                    "rent_id" => $bill['rent_id'],
                    "name" => $bill['name'],
                    "quantity" => $bill['quantity'],
                    "unit_price" => $bill['unit_price'],
                    "total_price" => $bill['total_price'],
                    "type" => $bill['type'],
                    "status" => $bill['status']
                ]);
            }
            // party

            DB::commit();
            return redirect()->route('party.all')
                ->with(['success' => 'تم إنشاء الحفله بنجاح']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء اضافه بيانات الحفله: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())
                ->with(['error' => 'حدث خطأ أثناء اضافه بيانات الحفله. يرجى المحاولة مرة أخرى.' . $e->getMessage()]);
        }
    }

    public function edit(Party $party)
    {
    }

    public function update(UpdatePartyRequest $request, Party $party)
    {
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
}
