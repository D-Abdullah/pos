<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Party;
use App\Models\Supplier;
use App\Models\WarehouseTransaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $rules = [
                'product' => 'nullable|exists:products,id',
                'supplier' => 'nullable|exists:suppliers,id',
                'party' => 'nullable|exists:parties,id',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date',
            ];

            $messages = [
                'product.exists' => 'المنتج غير موجود.',
                'supplier.exists' => 'المورد غير موجود.',
                'date_from.date' => 'تاريخ "من" غير صالح.',
                'date_to.date' => 'تاريخ "إلى" غير صالح.',
            ];

            $validatedData = $request->validate($rules, $messages);
            $purchases = Purchase::query();
            if ($request->filled('product')) {
                $purchases->where('product_id', $request->input('product'));
            }
            if ($request->filled('supplier')) {
                $purchases->where('supplier_id', $request->input('supplier'));
            }
            if ($request->filled('party')) {
                $purchases->where('party_id', $request->input('party'));
            }

            if ($request->filled('date_from')) {
                $purchases->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $purchases->whereDate('updated_at', '<=', $request->input('date_to'));
            }


            $purchases = $purchases->with(['supplier', 'product', 'party'])->paginate(PAGINATION);
            $suppliers = Supplier::all();
            $products = Product::all();
            $parties = Party::all();

            return view('pages.purchases.index', compact('purchases', 'products', 'suppliers', 'parties'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب عمليات الشراء: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب عمليات الشراء. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function store(StorePurchaseRequest $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->input('product_id'));
            $totalQty = $product->quantity + $request->input('quantity');
            $totalPrice = (float) floatval(Purchase::where('product_id', $product->id)->sum('total_price')) + (float) floatval((float) $request->input('unit_price') * (int) $request->input('quantity'));

            $purchase = Purchase::create([
                'product_id' => $request->input('product_id'),
                'supplier_id' => $request->input('supplier_id'),
                'date' => $request->input('date'),
                'quantity' => $request->input('quantity'),
                'unit_price' => $request->input('unit_price'),
                'total_price' => ((float) $request->input('unit_price') * (int) $request->input('quantity')),
                'party_id' => $request->has('party_id') ? $request->input('party_id') : null,
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            $product->update([
                'quantity' => $totalQty,
                'purchase_price' => $totalPrice / $totalQty,
            ]);

            WarehouseTransaction::create([
                'product_id' => $product->id,
                'rent_id' => null,
                'quantity' => $request->input('quantity'),
                'from' => 'المورد: ' . Supplier::findOrFail($request->input('supplier_id'))->name,
                'to' => "المخزن",
                'type' => 'purchases',
            ]);
            DB::commit();
            return redirect()->route('purchase.all')
                ->with(['success' => 'تم إنشاء عمليه الشراء بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء اضافه عمليه شراء: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())
                ->with(['error' => 'حدث خطأ أثناء اضافه عمليه شراء. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function update(UpdatePurchaseRequest $request, int $id)
    {
        try {
            DB::beginTransaction();
            $purchase = Purchase::findOrFail($id);
            $oldQty = $purchase->quantity;
            $product = Product::findOrFail($request->input('product_id'));
            $totalQty = $product->quantity + $request->input('quantity');
            $totalPrice = (float) floatval(Purchase::where('product_id', $product->id)->sum('total_price')) + (float) floatval((float) $request->input('unit_price') * (int) $request->input('quantity'));

            $purchase->update([
                'product_id' => $request->input('product_id'),
                'supplier_id' => $request->input('supplier_id'),
                'date' => $request->input('date'),
                'quantity' => $request->input('quantity'),
                'unit_price' => $request->input('unit_price'),
                'total_price' => ((float) $request->input('unit_price') * (int) $request->input('quantity')),
                'party_id' => $request->has('party_id') ? $request->input('party_id') : null,
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);
            $product->update([
                'quantity' => $totalQty,
                'purchase_price' => $totalPrice / $totalQty,
            ]);

            WarehouseTransaction::create([
                'product_id' => $product->id,
                'rent_id' => null,
                'quantity' => abs($request->input('quantity') - $oldQty),
                'from' => 'المورد: ' . Supplier::findOrFail($request->input('supplier_id'))->name,
                'to' => "المخزن",
                'type' => 'purchases',
            ]);
            DB::commit();
            return redirect()->route('purchase.all')->with(['success' => 'تم تحديث عملية الشراء بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث عملية الشراء: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث عملية الشراء. يرجى المحاولة مرة أخرى.']);
        }
    }


    public function destroy($id)
    {
        try {
            $purchase = Purchase::findOrFail($id);
            $product = Product::findOrFail($purchase->product_id);
            $totalQty = $product->quantity - $purchase->quantity;
            $totalPrice = (float) floatval(Purchase::where('product_id', $product->id)->sum('total_price')) - (float) floatval($purchase->total_price);
            $product->update([
                'quantity' => $totalQty,
                'purchase_price' => $totalPrice / $totalQty,
            ]);
            $purchase->delete();
            return redirect()->route('purchase.all')->with(['success' => 'تم حذف عمليه الشراء بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف عمليه الشراء: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف عمليه الشراء. يرجى المحاولة مرة أخرى.']);
        }
    }
}
