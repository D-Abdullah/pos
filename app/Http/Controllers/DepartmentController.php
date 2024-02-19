<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $rules = [
                'query' => 'nullable|string',
                'status' => 'nullable|boolean',
            ];

            $messages = [
                'query.string' => 'حقل البحث يجب أن يكون نصًا.',
                'status.boolean' => 'حقل الحالة يجب أن يكون قيمة منطقية.',
            ];

            $request->validate($rules, $messages);

            $departments = Department::query();

            if ($request->filled('query')) {
                $searchTerm = trim($request->input('query'));
                $departments->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($request->filled('status')) {
                $departments->where('is_active', $request->input('status'));
            }

            $departments = $departments->paginate(PAGINATION);

            return view('pages.categories.index', compact('departments'))
                ->with(
                    [
                        'query' => $request->filled('query') ? $request->input('query') : null,
                        'status' => $request->filled('status') ? $request->input('status') : null,
                    ]
                );
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب الأقسام: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب الأقسام. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreDepartmentRequest $request)
    {
        try {
            Department::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'is_active' => $request->has('is_active') ? 1 : 0,
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            return redirect()->route('department.all')->with(['success' => 'تم إنشاء القسم ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء انشاء قسم: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء انشاء قسم. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, $id)
    {
        try {
            $department = Department::findOrFail($id);

            $department->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'is_active' => $request->input('is_active') ? 1 : 0,
            ]);

            return redirect()->route('department.all')->with(['success' => 'تم تحديث القسم ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء تحديث القسم: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث القسم. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);

            $products = Product::where('department_id', $id)->get();

            foreach ($products as $product) {
                $product->delete();
            }

            $department->delete();

            return redirect()->route('department.all')->with(['success' => 'تم حذف القسم بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف القسم: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف القسم. يرجى المحاولة مرة أخرى.']);
        }
    }
}
