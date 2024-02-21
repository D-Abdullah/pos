<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $clients = Client::query();

            $clients = $clients->paginate(PAGINATION);

            return view('pages.clients.index', compact('clients'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء جلب العميلات: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب العملاء. يرجى المحاولة مرة أخرى.']);
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
                'is_active' => $request->has('is_active') ? 1 : 0,
                'added_by' => auth()->user()->getAuthIdentifier(),
            ]);

            return redirect()->route('client.all')->with(['success' => 'تم إنشاء العميل ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
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
                'is_active' => $request->input('is_active') ? 1 : 0
            ]);

            return redirect()->route('client.all')->with(['success' => 'تم تحديث العميل ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
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
