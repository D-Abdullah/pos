<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $rents = Rent::query();

            $rents = $rents->paginate(PAGINATION);

            return view('pages.rents.index', compact('rents'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء جلب الايجار: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب عنصر الايجار. يرجى المحاولة مرة أخرى.']);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRentRequest $request)
    {
        try {

            Rent::create([
                'name' => $request->input('name'),
                'sale_price' => $request->input('sale_price'),
                'rent_price' => $request->input('rent_price'),
                'quantity' => $request->input('quantity'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            return redirect()->route('rent.all')->with(['success' => 'تم إنشاء الايجار ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء انشاء ايجار: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء انشاء ايجار. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRentRequest $request, $id)
    {
        try {
            $rent = Rent::findOrFail($id);

            $rent->update([
                'name' => $request->input('name'),
                'sale_price' => $request->input('sale_price'),
                'rent_price' => $request->input('rent_price'),
                'quantity' => $request->input('quantity'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            return redirect()->route('rent.all')->with(['success' => 'تم تحديث الايجار ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث الايجار: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث الايجار. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $rent = Rent::findOrFail($id);
            $rent->delete();

            return redirect()->route('rent.all')->with(['success' => 'تم حذف الايجار بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف الايجار: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف الايجار. يرجى المحاولة مرة أخرى.']);
        }
    }
}
