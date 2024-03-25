<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $rules = [
                'q' => 'nullable|string',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date',
            ];

            $messages = [
                'q.string' => 'حقل البحث يجب أن يكون نصًا.',
                'date_from.date' => 'تاريخ "من" غير صالح.',
                'date_to.date' => 'تاريخ "إلى" غير صالح.',
            ];

            $request->validate($rules, $messages);

            $products = Product::query();

            if ($request->filled('q')) {
                $searchTerm = trim($request->input('q'));
                $products->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%');
                });
            }
            // Apply Date Filters
            if ($request->filled('date_from')) {
                $products->whereDate('created_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $products->whereDate('created_at', '<=', $request->input('date_to'));
            }

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
        try {
            Product::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'department_id' => $request->input('department_id'),
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
                'department_id' => $request->input('department_id'),
                'added_by' => auth()->user()->getAuthIdentifier(),
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
