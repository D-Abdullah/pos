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

            $departments = Department::query();

            if ($request->filled('q')) {
                $searchTerm = trim($request->input('q'));
                $departments->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%');
                });
            }
            // Apply Date Filters
            if ($request->filled('date_from')) {
                $departments->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $departments->whereDate('updated_at', '<=', $request->input('date_to'));
            }
            $departments = $departments->paginate(PAGINATION);

            return view('pages.categories.index', compact('departments'));
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
        // return auth()->user()->getAuthIdentifier();
        try {
            Department::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
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
                'added_by' => auth()->user()->getAuthIdentifier(),
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
            $department->delete();

            return redirect()->route('department.all')->with(['success' => 'تم حذف القسم بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف القسم: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف القسم. يرجى المحاولة مرة أخرى.']);
        }
    }
}
