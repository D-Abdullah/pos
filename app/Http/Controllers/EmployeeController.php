<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'name' => 'nullable|string',
                'phone' => 'nullable|string',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date',
            ];

            $messages = [
                'name.string' => 'حقل البحث بالاسم يجب أن يكون نصًا.',
                'phone.string' => 'حقل البحث بالهاتف يجب أن يكون نصًا.',
                'date_from.date' => 'تاريخ "من" غير صالح.',
                'date_to.date' => 'تاريخ "إلى" غير صالح.',
            ];

            $request->validate($rules, $messages);

            $employees = Employee::query();

            if ($request->filled('name')) {
                $employees->where('name', 'LIKE', '%' . $request->input('name') . '%');
            }

            if ($request->filled('phone')) {
                $employees->where('phone', 'LIKE', '%' . $request->input('phone') . '%');
            }

            if ($request->filled('date_from')) {
                $employees->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $employees->whereDate('updated_at', '<=', $request->input('date_to'));
            }

            $employees = $employees->paginate(PAGINATION);

            DB::commit();
            return view('pages.employee.index', compact('employees'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء جلب الموظفين: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب الموظفين. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function store(EmployeeRequest $request)
    {
        try {
            DB::beginTransaction();
            //code
            Employee::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'custody' => 0,
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);
            DB::commit();
            return redirect()->route('employee.all')->with(['success' => 'تم إنشاء الموظف ' . $request->input('name') . ' بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء انشاء الموظف: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء انشاء الموظف. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function update(EmployeeRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            //code
            $employee = Employee::findOrFail($id);
            $employee->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            DB::commit();
            return redirect()->route('employee.all')->with(['success' => 'تم تحديث الموظف ' . $request->input('name') . ' بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث الموظف: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء تحديث الموظف. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            //code
            $employee = Employee::findOrFail($id);
            if ($employee->custody != 0) {
                return redirect()->back()->with(['error' => 'لا يمكن حذف الموظف الذي يحتوي على قيمة في العده. يرجى المحاولة مرة أخرى.']);
            } else {
                $employee->delete();
            }

            DB::commit();
            return redirect()->route('employee.all')->with(['success' => 'تم حذف الموظف بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء حذف الموظف: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف الموظف. يرجى المحاولة مرة أخرى.']);
        }
    }
}
