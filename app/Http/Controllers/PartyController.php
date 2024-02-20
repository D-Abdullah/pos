<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Http\Requests\StorePartyRequest;
use App\Http\Requests\UpdatePartyRequest;
use App\Http\Resources\PartyResource;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $party = Party::paginate(PAGINATION);
        return view('pages.party.index', compact('party'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.party.add');
    }

    /**
     * Store a newly created resource in storage.
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
    public function createBill()
    {
        return view('pages.party.addBill');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeBill(Request $request)
    {
        return $request->all();
    }

    /**
     * Display the specified resource.
     */
    public function show(Party $party)
    {
        return new PartyResource($party);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Party $party)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartyRequest $request, Party $party)
    {
        $party->update($request->validated());
        return new PartyResource($party);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Party $party)
    {
        if (!auth()->check()) {
            return response()->json(['Unauthenticated'], 401);
        } else {
            $party->delete();
            return response()->noContent();
        }
    }
}
