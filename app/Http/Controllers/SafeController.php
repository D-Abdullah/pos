<?php

namespace App\Http\Controllers;

use App\Http\Requests\SafeRequest;
use App\Models\Safe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SafeController extends Controller
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

            $safes = Safe::query();

            if ($request->filled('name')) {
                $safes->where('name', 'LIKE', '%' . $request->input('name') . '%');
            }

            if ($request->filled('date_from')) {
                $safes->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $safes->whereDate('updated_at', '<=', $request->input('date_to'));
            }

            $safes = $safes->paginate(PAGINATION);

            DB::commit();
            return view('pages.safe.index', compact('safes'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء جلب الخزن: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب الخزن. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function store(SafeRequest $request)
    {
        try {
            DB::beginTransaction();
            //code
            Safe::create([
                'name' => $request->input('name'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);
            DB::commit();
            return redirect()->route('safe.all')->with(['success' => 'تم إنشاء الخزنه ' . $request->input('name') . ' بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء انشاء الخزنه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء انشاء الخزنه. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function update(SafeRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            //code
            $safe = Safe::findOrFail($id);
            $safe->update([
                'name' => $request->input('name'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            DB::commit();
            return redirect()->route('safe.all')->with(['success' => 'تم تحديث الخزنه ' . $request->input('name') . ' بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث الخزنه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء تحديث الخزنه. يرجى المحاولة مرة أخرى.']);
        }
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            //code
            $safe = Safe::findOrFail($id);
            $safe->delete();

            DB::commit();
            return redirect()->route('safe.all')->with(['success' => 'تم حذف الخزنه بنجاح.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء حذف الخزنه: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف الخزنه. يرجى المحاولة مرة أخرى.']);
        }
    }
}
