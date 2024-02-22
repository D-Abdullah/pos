<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Party;
use App\Http\Requests\StorePartyRequest;
use App\Http\Requests\UpdatePartyRequest;
use App\Models\Client;
use App\Models\Product;
use App\Models\WarehouseTransaction;
use Illuminate\Http\Request;
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

            $parties = $parties->with('client')->paginate(PAGINATION);
            return view('pages.party.index', compact('parties'));
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

            return redirect()->back()->with(['error' =>
            'حدث خطأ أثناء جلب صفحه اضافه الحفله. يرجى المحاولة مرة أخرى.']);
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
        return view('pages.party.addBill', compact('id'));
    }

    /**
     * Party Controller Create Method
     + Store the Form For Only Party Bill Data
     */
    public function storeBill(Request $request, int $id)
    {
        return $request->all();
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
