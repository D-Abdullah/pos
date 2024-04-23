<?php

namespace App\Http\Controllers;

use App\Http\Requests\FTRequest;
use App\Models\Employee;
use App\Models\FinancialTransaction;
use App\Models\FinancialTransactionType;
use App\Models\Party;
use App\Models\Safe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class FinancialTransactionController extends Controller
{
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'type' => ['nullable', 'string', Rule::in(['income', 'expense'])],
                'party' => ['nullable', 'numeric', 'exists:parties,id'],
                'FTType' => ['nullable', 'numeric', 'exists:financial_transaction_types,id'],
                'from' => ['nullable', 'string', Rule::in(['custody', 'safe'])],
                'employee' => ['nullable', 'numeric', 'exists:employees,id'],
                'safe' => ['nullable', 'numeric', 'exists:safes,id'],
                'date_from' => ['nullable', 'date'],
                'date_to' => ['nullable', 'date'],
            ];

            $messages = [
                'type.in' => 'يجب أن يكون النوع إما "الدخل" أو "المصروف"',
                'party.exists' => 'الحفله المحدد غير موجود',
                'FTType.exists' => 'نوع المعاملة المالية المحدد غير موجود',
                'from.in' => 'يجب أن يكون مصدر المعاملة إما "العهدة" أو "الخزينة"',
                'employee.exists' => 'الموظف المحدد غير موجود',
                'safe.exists' => 'الخزينة المحددة غير موجودة',
                'date_from.date' => 'تنسيق التاريخ يجب أن يكون Y-m-d',
                'date_to.date' => 'تنسيق التاريخ يجب أن يكون Y-m-d',
            ];
            $request->validate($rules, $messages);
            $fts = FinancialTransaction::query();

            if ($request->filled('type')) {
                $fts->where('type', $request->input('type'));
            }
            if ($request->filled('party')) {
                $fts->where('party_id', $request->input('party'));
            }
            if ($request->filled('FTType')) {
                $fts->where('financial_transaction_type_id', $request->input('FTType'));
            }
            if ($request->filled('from')) {
                $fts->where('from', $request->input('from'));
            }
            if ($request->filled('employee')) {
                $fts->where('employee_id', $request->input('employee'));
            }
            if ($request->filled('safe')) {
                $fts->where('safe_id', $request->input('safe'));
            }

            if ($request->filled('date_from')) {
                $fts->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $fts->whereDate('updated_at', '<=', $request->input('date_to'));
            }

            $fts = $fts->with('party', 'employee', 'financial_transaction_type', 'safe', )->paginate(PAGINATION);
            $ftTypes = FinancialTransactionType::all();
            $parties = Party::all();
            $safes = Safe::all();
            $employees = Employee::all();
            DB::commit();
            return view('pages.ft.index', compact('fts', 'ftTypes', 'parties', 'safes', 'employees'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء جلب المعاملات الماليه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب المعاملات الماليه. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function store(FTRequest $request)
    {
        try {
            DB::beginTransaction();
            //code
            $ft = FinancialTransaction::create([
                'type' => $request->input('type'),
                'description' => $request->input('description'),
                'amount' => $request->input('amount'),
                'party_id' => $request->input('party_id'),
                'financial_transaction_type_id' => $request->input('financial_transaction_type_id'),
                'from' => $request->input('from'),
                'employee_id' => $request->input('employee_id'),
                'safe_id' => $request->input('safe_id'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);


            if ($ft->from == 'custody') {
                if ($ft->type == 'income') {
                    $employee = Employee::findOrFail($ft->employee_id)->first();
                    $employee->custody += $ft->amount;
                    $employee->save();
                } else if ($ft->type == 'expense') {
                    $employee = Employee::findOrFail($ft->employee_id)->first();
                    $employee->custody -= $ft->amount;
                    $employee->save();
                }
            }



            DB::commit();
            return redirect()->route('ft.all')->with(['success' => 'تم إنشاء المعامله الماليه بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء انشاء المعامله الماليه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء انشاء المعامله الماليه. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function update(FTRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            //code
            $ft = FinancialTransaction::findOrFail($id);
            $oldAmount = $ft->first()->amount;
            if ($ft->from != $request->input('from') || $ft->type != $request->input('type')) {
                if ($ft->from == 'custody') {
                    $oldAmount = 0;
                    $employee = Employee::findOrFail($ft->employee_id);
                    if ($ft->type == 'income') {
                        $employee->custody -= $ft->amount;
                    } else if ($ft->type == 'expense') {
                        $employee->custody += $ft->amount;
                    }
                    $employee->save();
                }
            }

            $ft->update([
                'type' => $request->input('type'),
                'description' => $request->input('description'),
                'amount' => $request->input('amount'),
                'party_id' => $request->input('party_id'),
                'financial_transaction_type_id' => $request->input('financial_transaction_type_id'),
                'from' => $request->input('from'),
                'employee_id' => $request->input('employee_id'),
                'safe_id' => $request->input('safe_id'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            if ($ft->from == 'custody') {
                if ($ft->type == 'income') {
                    $employee = Employee::findOrFail($ft->employee_id)->first();
                    $employee->custody += $request->input('amount') - $oldAmount;
                    $employee->save();
                } else if ($ft->type == 'expense') {
                    $employee = Employee::findOrFail($ft->employee_id)->first();
                    $employee->custody -= $request->input('amount') - $oldAmount;
                    $employee->save();
                }
            }

            DB::commit();
            return redirect()->route('ft.all')->with(['success' => 'تم تحديث المعامله الماليه بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث المعامله الماليه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء تحديث المعامله الماليه. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            //code
            $ft = FinancialTransaction::findOrFail($id);
            $ft->delete();

            DB::commit();
            return redirect()->route('ft.all')->with(['success' => 'تم حذف المعامله الماليه بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء حذف المعامله الماليه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف المعامله الماليه. يرجى المحاولة مرة أخرى.']);
        }
    }
}
