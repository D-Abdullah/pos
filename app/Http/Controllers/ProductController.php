<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::query();
            // filter
            $products = $products->paginate(PAGINATION);
            $departments = Department::all();
            return view('pages.items.index', compact('products', 'departments'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء جلب المنتجات: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب المنتجات. يرجى المحاولة مرة أخرى.']);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        return $request->all();
        try {
            Product::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'department_id' => $request->input('department_id'),
                'is_active' => $request->has('is_active') ? 1 : 0,
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            return redirect()->route('product.all')->with(['success' => 'تم إنشاء المنتج ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء انشاء المنتج: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء انشاء المنتج . يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $product->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'quantity' => $request->input('quantity'),
                'department_id' => $request->input('department_id'),
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            return redirect()->route('product.all')->with(['success' => 'تم تحديث المنتج ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث المنتج: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث المنتج. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            $product->delete();

            return redirect()->route('product.all')->with(['success' => 'تم حذف المنتج بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف المنتج: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف المنتج. يرجى المحاولة مرة أخرى.']);
        }
    }
}
