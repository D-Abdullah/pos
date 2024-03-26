<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Deposit;
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
    public function index()
    {
        try {
            $purchases = Purchase::query();

            $purchases = $purchases->with(['supplier', 'product'])->paginate(PAGINATION);

            $suppliers = Supplier::all();
            $products = Product::all();

            return view('pages.purchases.index', compact('purchases', 'products', 'suppliers'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب عمليات الشراء: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب عمليات الشراء. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function store(StorePurchaseRequest $request)
    {
        try {
            DB::beginTransaction();
            $purchase = Purchase::create([
                'product_id' => $request->input('product_id'),
                'supplier_id' => $request->input('supplier_id'),
                'date' => $request->input('date'),
                'quantity' => $request->input('quantity'),
                'unit_price' => $request->input('unit_price'),
                'total_price' => ((float) $request->input('unit_price') * (int) $request->input('quantity')),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);
            $product = Product::findOrFail($request->input('product_id'));
            $product->update(['quantity' => $product->quantity + $request->input('quantity')]);

            WarehouseTransaction::create([
                'product_id' => $product->id,
                'quantity' => $request->input('quantity'),
                'from' => 'المورد: ' . Supplier::findOrFail($request->input('supplier_id'))->name,
                'to' => "المخزن",
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
            $purchase->update([
                'product_id' => $request->input('product_id'),
                'supplier_id' => $request->input('supplier_id'),
                'date' => $request->input('date'),
                'quantity' => $request->input('quantity'),
                'unit_price' => $request->input('unit_price'),
                'total_price' => ((float) $request->input('unit_price') * (int) $request->input('quantity')),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);
            $product = Product::findOrFail($request->input('product_id'));
            $product->update(['quantity' => $product->quantity + $request->input('quantity') - $oldQty]);

            WarehouseTransaction::create([
                'product_id' => $product->id,
                'quantity' => $request->input('quantity') - $oldQty,
                'from' => 'المورد: ' . Supplier::findOrFail($request->input('supplier_id'))->name,
                'to' => "المخزن",
            ]);
            DB::commit();
            return redirect()->route('purchase.all')->with(['success' => 'تم تحديث دفعات عملية الشراء بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث عملية الشراء: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث دفعات عملية الشراء. يرجى المحاولة مرة أخرى.']);
        }
    }


    public function destroy($id)
    {
        try {
            $purchase = Purchase::findOrFail($id);

            $purchase->delete();

            return redirect()->route('purchase.all')->with(['success' => 'تم حذف عمليه الشراء بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف عمليه الشراء: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف عمليه الشراء. يرجى المحاولة مرة أخرى.']);
        }
    }
}
