<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Models\Rent;
use App\Models\Supplier;
use App\Models\WarehouseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $rules = [
                'supplier' => 'nullable|exists:suppliers,id',
                'name' => 'nullable|string',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date',
            ];

            $messages = [
                'supplier.exists' => 'المورد غير موجود.',
                'name.string' => 'الاسم غير صالح.',
                'date_from.date' => 'تاريخ "من" غير صالح.',
                'date_to.date' => 'تاريخ "إلى" غير صالح.',
            ];

            $validatedData = $request->validate($rules, $messages);
            $rents = Rent::query();
            if ($request->filled('q')) {
                $rents->where('name', 'LIKE', '%' . $request->input('q') . '%');
            }

            if ($request->filled('date_from')) {
                $rents->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $rents->whereDate('updated_at', '<=', $request->input('date_to'));
            }
            if ($request->filled('supplier')) {
                $rents->where('supplier_id', $request->input('supplier'));
            }
            $rents = $rents->paginate(PAGINATION);
            $suppliers = Supplier::all();
            return view('pages.rents.index', compact('rents', 'suppliers'));
        } catch (\Exception $e) {
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
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                $imageName = time() . '_' . $image->hashName();
                $image->move(base_path('imgs'), $imageName);
                $imagePath = 'imgs/' . $imageName;
            }
            $rent = Rent::create([
                'name' => $request->input('name'),
                'sale_price' => $request->input('sale_price'),
                'rent_price' => $request->input('rent_price'),
                'quantity' => $request->input('quantity'),
                'total_price' => $request->input('rent_price') * $request->input('quantity'),
                'image' => $imagePath ?? 'imgs/default.png',
                'supplier_id' => $request->input('supplier_id'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);


            WarehouseTransaction::create([
                'rent_id' => $rent->id,
                'quantity' => $request->input('quantity'),
                'from' => 'المورد: ' . Supplier::findOrFail($request->input('supplier_id'))->name,
                'to' => "مخزن الإيجار",
            ]);

            return redirect()->route('rent.all')->with(['success' => 'تم إنشاء الايجار ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
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
            $oldQty = $rent->quantity;
            if ($request->hasFile('image')) {
                $oldImage = $rent->image;
                if (!empty($oldImage)) {
                    if ($oldImage != "imgs/default.png") {
                        $oldImagePath = base_path($oldImage);
                        if (File::exists($oldImagePath)) {
                            File::delete($oldImagePath);
                        }
                    }
                }
                $image = $request->file('image');
                $imageName = time() . '_' . $image->hashName();
                $image->move(base_path('imgs'), $imageName);

                $rent->image = 'imgs/' . $imageName;
            }
            $rent->update([
                'name' => $request->input('name'),
                'sale_price' => $request->input('sale_price'),
                'rent_price' => $request->input('rent_price'),
                'quantity' => $request->input('quantity'),
                'total_price' => $request->input('rent_price') * $request->input('quantity'),
                'added_by' => auth()->user()->getAuthIdentifier(),
                'supplier_id' => $request->input('supplier_id'),
            ]);
            WarehouseTransaction::create([
                'rent_id' => $rent->id,
                'quantity' => abs($request->input('quantity') - $oldQty),
                'from' => 'المورد: ' . Supplier::findOrFail($request->input('supplier_id'))->name,
                'to' => "مخزن الإيجار",
            ]);
            return redirect()->route('rent.all')->with(['success' => 'تم تحديث الايجار ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
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
