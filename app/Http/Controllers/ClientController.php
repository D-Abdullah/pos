<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Deposit;
use App\Models\Employee;
use App\Models\Safe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
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

            $validatedData = $request->validate($rules, $messages);

            $clients = Client::query();

            if ($request->filled('name')) {
                $clients->where('name', 'LIKE', '%' . $request->input('name') . '%');
            }

            if ($request->filled('phone')) {
                $clients->where('phone', 'LIKE', '%' . $request->input('phone') . '%');
            }

            if ($request->filled('date_from')) {
                $clients->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $clients->whereDate('updated_at', '<=', $request->input('date_to'));
            }

            $clients = $clients->with("deposits", 'parties')->paginate(PAGINATION);
            foreach ($clients as $client) {
                $totalRequired = $client->parties()->sum('total_price');
                $totalPaid = $client->deposits()->where('is_paid', '1')->sum('cost');
                $totalReceivables = $totalRequired - $totalPaid;

                $client->total_required = $totalRequired;
                $client->total_paid = $totalPaid;
                $client->total_receivables = $totalReceivables;
            }
            $safes = Safe::all();
            $employees = Employee::all();
            return view('pages.clients.index', compact('clients', 'safes', 'employees'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب العملاء: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب العملاء. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function deposits(Request $request, $id)
    {
        // return $request->all();
        try {
            $client = Client::find($id);
            if (!$client) {
                return redirect()->back()->with(['error' => 'حدث خطأ انت تحاول تحديث عميل غير موجود.']);
            }

            # equations
            $totalRequired = $client->parties()->sum('total_price');
            $totalPaid = $client->deposits()->where('is_paid', '1')->sum('cost');
            $totalReceivables = $totalRequired - $totalPaid;
            ##################################################
            $depositsCollection = collect($request->input('deposits'));
            $totalCost = $depositsCollection->sum('cost');
            if ($totalRequired < $totalCost) {
                return redirect()->back()->withInput($request->all())->with(['error' => 'المبلغ المدفوع اكبر من المبلغ المطلوب.']);
            }
            if ($client->deposits->count() > 0) {
                foreach ($request->input('deposits') as $deposit) {
                    if (isset($deposit['id'])) {
                        $depositM = Deposit::where('id', $deposit['id']);
                        $depositM->update([
                            'is_paid' => $deposit['is_paid'] ?? 0,
                        ]);
                    } else {
                        Deposit::create([
                            'cost' => $deposit['cost'],
                            'date' => $deposit['date'],
                            'type' => "client",
                            'is_paid' => $deposit['is_paid'] ?? 0,
                            'client_id' => $client->id,
                            'from' => $deposit['from'],
                            'employee_id' => $deposit['from'] == 'custody' ? $deposit['employee_id'] : null,
                            'safe_id' => $deposit['from'] == 'safe' ? $deposit['safe_id'] : null,
                            'supplier_id' => null,
                        ]);
                    }
                }
            } else {
                foreach ($request->input('deposits') as $deposit) {
                    Deposit::create([
                        'cost' => $deposit['cost'],
                        'date' => $deposit['date'],
                        'type' => "client",
                        'is_paid' => $deposit['is_paid'] ?? 0,
                        'client_id' => $client->id,
                        'from' => $deposit['from'],
                        'employee_id' => $deposit['from'] == 'custody' ? $deposit['employee_id'] : null,
                        'safe_id' => $deposit['from'] == 'safe' ? $deposit['safe_id'] : null,
                        'supplier_id' => null,
                    ]);
                }
            }
            return redirect()->route('client.all')->with(['success' => 'تم تحديث دفعات المورد ' . $client->name . ' بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء تحديث العميل: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث العميل. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        try {
            Client::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            return redirect()->route('client.all')->with(['success' => 'تم إنشاء العميل ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء انشاء العميل: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء انشاء العميل. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, $id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            return redirect()->route('client.all')->with(['success' => 'تم تحديث العميل ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء تحديث العميل: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث العميل. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();

            return redirect()->route('client.all')->with(['success' => 'تم حذف العميل بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف العميل: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف العميل. يرجى المحاولة مرة أخرى.']);
        }
    }
}
