<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Http\Requests\StorePartyRequest;
use App\Http\Requests\UpdatePartyRequest;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Party Controller Index Method
     + Show the datatable with party data and bills and warehouse data needed
     */
    public function index()
    {
        $party = Party::paginate(PAGINATION);
        return view('pages.party.index', compact('party'));
    }

    /**
     * Party Controller Create Method
     + Show the Form For Only Party Data
     */
    public function create()
    {
        return view('pages.party.add');
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
