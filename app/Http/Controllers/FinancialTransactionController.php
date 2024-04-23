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

class FinancialTransactionController extends Controller
{
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = [

            ];

            $messages = [

            ];

            $request->validate($rules, $messages);

            $fts = FinancialTransaction::query();

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
            FinancialTransaction::create([
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
