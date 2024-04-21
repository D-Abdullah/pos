<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $rules = [
                'name' => 'nullable|string',
                'email' => 'nullable|string',
                'phone' => 'nullable|string',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date',
            ];

            $messages = [
                'name.string' => 'الاسم غير صالح.',
                'email.string' => 'البريد الإلكتروني غير صالح.',
                'phone.string' => 'رقم الهاتف غير صالح.',
                'date_from.date' => 'تاريخ "من" غير صالح.',
                'date_to.date' => 'تاريخ "إلى" غير صالح.',
            ];

            $validatedData = $request->validate($rules, $messages);
            $suppliers = Supplier::query();
            // filters
            if ($request->filled('name')) {
                $suppliers->where('name', 'LIKE', '%' . $request->input('name') . '%');
            }
            if ($request->filled('email')) {
                $suppliers->where('email', 'LIKE', '%' . $request->input('email') . '%');
            }
            if ($request->filled('phone')) {
                $suppliers->where('phone', 'LIKE', '%' . $request->input('phone') . '%');
            }

            if ($request->filled('date_from')) {
                $suppliers->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $suppliers->whereDate('updated_at', '<=', $request->input('date_to'));
            }
            $suppliers = $suppliers->with('deposits', 'purchases')->paginate(PAGINATION);
            foreach ($suppliers as $supplier) {
                $totalRequired = $supplier->purchases()->sum('total_price') + $supplier->rents()->sum('total_price');
                $totalPaid = $supplier->deposits()->where('is_paid', '1')->sum('cost');
                $totalReceivables = $totalRequired - $totalPaid;

                $supplier->total_required = $totalRequired;
                $supplier->total_paid = $totalPaid;
                $supplier->total_receivables = $totalReceivables;
            }
            $products = Product::all();
            return view('pages.suppliers.index', compact('suppliers', 'products'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب الموردات: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب الموردات. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        try {
            supplier::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'payment_type' => $request->input('payment_type'),
                'is_active' => $request->has('is_active') ? 1 : 0,
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            return redirect()->route('supplier.all')->with(['success' => 'تم إنشاء المورد ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء انشاء المورد: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء انشاء المورد. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, $id)
    {
        try {
            $supplier = Supplier::findOrFail($id);

            $supplier->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'payment_type' => $request->input('payment_type'),
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            return redirect()->route('supplier.all')->with(['success' => 'تم تحديث المورد ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء تحديث المورد: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث المورد. يرجى المحاولة مرة أخرى.']);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function deposits(Request $request, $id)
    {
        try {
            $supplier = Supplier::find($id);
            if (!$supplier) {
                return redirect()->back()->with(['error' => 'حدث خطأ انت تحاول تحديث مورد غير موجود.']);
            }

            # equations
            $totalRequired = $supplier->purchases()->sum('total_price') + $supplier->rents()->sum('total_price');
            $totalPaid = $supplier->deposits()->where('is_paid', '1')->sum('cost');
            $totalReceivables = $totalRequired - $totalPaid;
            ##################################################
            $depositsCollection = collect($request->input('deposits'));
            $totalCost = $depositsCollection->sum('cost');
            if ($totalRequired < $totalCost) {
                return redirect()->back()->withInput($request->all())->with(['error' => 'المبلغ المدفوع اكبر من المبلغ المطلوب.']);
                // return redirect()->back()->withInput($request->all())->with(['error' => 'total = ' . $totalCost . ' | req = ' . $totalRequired]);
            }
            if ($totalRequired != $totalCost && $supplier->payment_type == 'cash') {
                return redirect()->back()->withInput($request->all())->with(['error' => 'هذا المورد لا يقبل دفعات لذا يرجى التأكد من دفع كل المستحقات دفعه واحده.']);
                // return redirect()->back()->withInput($request->all())->with(['error' => ' total = ' . $totalCost . ' | req = ' . $totalRequired . ' con = ' . ((int) $totalRequired != (int) $totalCost ? "yes" : "no")]);
            }
            if ($supplier->deposits->count() > 0) {
                foreach ($request->input('deposits') as $deposit) {
                    if (isset($deposit['id'])) {
                        $depositM = Deposit::where('id', $deposit['id']);
                        $depositM->update([
                            'cost' => $deposit['cost'],
                            'date' => $deposit['date'],
                            'is_paid' => $deposit['is_paid'] ?? 0,
                        ]);
                    } else {
                        Deposit::create([
                            'cost' => $deposit['cost'],
                            'date' => $deposit['date'],
                            'type' => "supplier",
                            'is_paid' => $deposit['is_paid'] ?? 0,
                            'supplier_id' => $supplier->id,
                        ]);
                    }
                }
            } else {
                foreach ($request->input('deposits') as $deposit) {
                    Deposit::create([
                        'cost' => $deposit['cost'],
                        'date' => $deposit['date'],
                        'type' => "supplier",
                        'is_paid' => $deposit['is_paid'] ?? 0,
                        'supplier_id' => $supplier->id,
                    ]);
                }
            }
            return redirect()->route('supplier.all')->with(['success' => 'تم تحديث دفعات المورد ' . $supplier->name . ' بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء تحديث المورد: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث المورد. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            return redirect()->route('supplier.all')->with(['success' => 'تم حذف المورد بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف المورد: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف المورد. يرجى المحاولة مرة أخرى.']);
        }
    }
}
