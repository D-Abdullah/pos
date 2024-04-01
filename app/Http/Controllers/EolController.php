<?php

namespace App\Http\Controllers;

use App\Models\Eol;
use App\Http\Requests\StoreEolRequest;
use App\Http\Requests\UpdateEolRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $rules = [
                'product' => 'nullable|exists:products,id',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date',
            ];

            $messages = [
                'product.exists' => 'المنتج غير موجود.',
                'date_from.date' => 'تاريخ "من" غير صالح.',
                'date_to.date' => 'تاريخ "إلى" غير صالح.',
            ];

            $validatedData = $request->validate($rules, $messages);
            $eols = Eol::query();

            if ($request->filled('product')) {
                $eols->where('product_id', $request->input('product'));
            }

            if ($request->filled('date_from')) {
                $eols->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $eols->whereDate('updated_at', '<=', $request->input('date_to'));
            }

            $eols = $eols->with('product')->paginate(PAGINATION);
            $products = Product::all();
            return view('pages.eol.index', compact('eols', 'products'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء جلب الهالك: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب الهالك. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function store(StoreEolRequest $request)
    {
        try {
            Eol::create([
                'product_id' => $request->input('product_id'),
                'reason' => $request->input('reason'),
                'quantity' => $request->input('quantity'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            return redirect()->route('eol.all')->with(['success' => 'تم إنشاء الهالك ' . Product::find($request->input('product_id'))->name . ' بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء انشاء الهالك: ' . $e->getMessage());

            // return $e->getMessage();
            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء انشاء الهالك. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEolRequest $request, $id)
    {
        try {
            $eol = Eol::findOrFail($id);
            $eol->update([
                'product_id' => $request->input('product_id'),
                'reason' => $request->input('reason'),
                'quantity' => $request->input('quantity'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            return redirect()->route('eol.all')->with(['success' => 'تم تحديث الهالك ' . Product::find($request->input('product_id'))->name . ' ' . $request->input('quantity') . ' بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث الهالك: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث الهالك. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $eol = Eol::findOrFail($id);

            $eol->delete();

            return redirect()->route('eol.all')->with(['success' => 'تم حذف الهالك بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف الهالك: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف الهالك. يرجى المحاولة مرة أخرى.']);
        }
    }
}
