<?php

namespace App\Http\Controllers;

use App\Http\Requests\FtTypeRequest;
use App\Models\FinancialTransactionType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FinancialTransactionTypeController extends Controller
{
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'name' => 'nullable|string',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date',
            ];

            $messages = [
                'name.string' => 'حقل البحث بالاسم يجب أن يكون نصًا.',
                'date_from.date' => 'تاريخ "من" غير صالح.',
                'date_to.date' => 'تاريخ "إلى" غير صالح.',
            ];

            $request->validate($rules, $messages);

            $ftTypes = FinancialTransactionType::query();

            if ($request->filled('name')) {
                $ftTypes->where('name', 'LIKE', '%' . $request->input('name') . '%');
            }

            if ($request->filled('date_from')) {
                $ftTypes->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $ftTypes->whereDate('updated_at', '<=', $request->input('date_to'));
            }

            $ftTypes = $ftTypes->paginate(PAGINATION);

            DB::commit();
            return view('pages.ft_type.index', compact('ftTypes'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء جلب انواع المعاملات الماليه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب انواع المعاملات الماليه. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function store(FtTypeRequest $request)
    {
        try {
            DB::beginTransaction();
            //code
            FinancialTransactionType::create([
                'name' => $request->input('name'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);
            DB::commit();
            return redirect()->route('ft.type.all')->with(['success' => 'تم إنشاء نوع المعامله الماليه ' . $request->input('name') . ' بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء انشاء نوع المعامله الماليه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء انشاء نوع المعامله الماليه. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function update(FtTypeRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            //code
            $ftType = FinancialTransactionType::findOrFail($id);
            $ftType->update([
                'name' => $request->input('name'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            DB::commit();
            return redirect()->route('ft.type.all')->with(['success' => 'تم تحديث نوع المعامله الماليه ' . $request->input('name') . ' بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث نوع المعامله الماليه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء تحديث نوع المعامله الماليه. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            //code
            $ftType = FinancialTransactionType::findOrFail($id);
            $ftType->delete();

            DB::commit();
            return redirect()->route('ft.type.all')->with(['success' => 'تم حذف نوع المعامله الماليه بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء حذف نوع المعامله الماليه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف نوع المعامله الماليه. يرجى المحاولة مرة أخرى.']);
        }
    }
}
