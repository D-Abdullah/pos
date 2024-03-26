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

            $purchases = $purchases->with(['deposits', 'supplier', 'product'])->paginate(PAGINATION);

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
        // $deposits = $request->input('deposits');
        // $deposits_total_cost = 0;
        // for ($i = 0; $i < count($deposits); $i++) {
        //     $deposits_total_cost += $deposits[$i]['cost'];
        // }
        // if ($deposits_total_cost > $request->input('total_price')) {
        //     return redirect()->back()->withInput($request->all())
        //         ->with(['error' => 'لا يمكن ان يكون قيمة الدفعات اكبر من السعر الإجمالي.']);
        // }
        try {
            DB::beginTransaction();
            $purchase = Purchase::create([
                'product_id' => $request->input('product_id'),
                'supplier_id' => $request->input('supplier_id'),
                'date' => $request->input('date'),
                'quantity' => $request->input('quantity'),
                'unit_price' => $request->input('unit_price'),
                'total_price' => (float) $request->input('unit_price') * (int) $request->input('quantity'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            // if ($request->input('deposits')) {
            //     for ($i = 0; $i < count($request->input('deposits')); $i++) {
            //         $deposit = new Deposit();
            //         $deposit->purchase_id = $purchase->id;
            //         $deposit->type = "purchase";
            //         $deposit->cost = $request->input('deposits')[$i]['cost'];
            //         $deposit->date = $request->input('deposits')[$i]['date'];
            //         $deposit->save();
            //     }
            // }
            $product = Product::findOrFail($request->input('product_id'));
            $product->update(['quantity' => $product->quantity + $request->input('quantity')]);

            WarehouseTransaction::create([
                'product_id' => $product->id,
                'quantity' => $request->input('quantity'),
                'from' => Supplier::findOrFail($request->input('supplier_id'))->name,
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
            $validatedData = $request->validated();
            $depositsTotalCost = array_sum(array_column($validatedData['deposits'], 'cost'));

            if ($depositsTotalCost > $purchase->total_price) {
                return redirect()->back()->withInput($validatedData)->with(['error' => 'لا يمكن أن يكون مجموع الدفعات أكبر من السعر الإجمالي.']);
            }

            $purchase->deposits()->delete();

            if (!empty($validatedData['deposits'])) {
                foreach ($validatedData['deposits'] as $depositData) {
                    $purchase->deposits()->create([
                        'type' => 'purchase',
                        'cost' => $depositData['cost'],
                        'date' => $depositData['date'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('purchase.all')->with(['success' => 'تم تحديث دفعات عملية الشراء بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث عملية الشراء: ' . $e->getMessage());

            return redirect()->back()->withInput($validatedData)->with(['error' => 'حدث خطأ أثناء تحديث دفعات عملية الشراء. يرجى المحاولة مرة أخرى.']);
        }
    }


    public function destroy(Purchase $purchase)
    {
    }
}
