<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Http\Requests\StorePartyRequest;
use App\Http\Requests\UpdatePartyRequest;
use App\Models\Client;
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
            DB::rollBack();
            Log::error('حدث خطأ أثناء جلب صفحه اضافه الحفله: ' . $e->getMessage());

            return redirect()->back()->with(['error' =>
            'حدث خطأ أثناء جلب صفحه اضافه الحفله. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Party Controller Update Method
     + Store the Form For Only Party Data
     */
    public function store(Request $request)
    {
        if (
            isset($_SERVER['HTTP_REFERER'])
            && strpos($_SERVER['HTTP_REFERER'], 'submit')
        ) {
            return $request->all();
        } else {
            return redirect()->to(route('party.addBill'));
        }
    }
    public function storeR(Request $request)
    {
        if (
            isset($_SERVER['HTTP_REFERER'])
            && strpos($_SERVER['HTTP_REFERER'], 'submit')
        ) {
            return $request->all();
        } else {
            return redirect()->to(route('party.addBill'));
        }
    }

    /**
     * Party Controller Create Method
     + Show the Form For Only Party Bill Data
     */
    public function createBill()
    {
        return view('pages.party.addBill');
    }

    /**
     * Party Controller Create Method
     + Store the Form For Only Party Bill Data
     */
    public function storeBill(Request $request)
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
