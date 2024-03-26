<?php

namespace App\Http\Controllers;

use App\Models\Eol;
use App\Models\Product;
use App\Models\WarehouseTransaction;
use App\Http\Requests\StoreWarehouseTransactionRequest;
use App\Http\Requests\UpdateWarehouseTransactionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WarehouseTransactionController extends Controller
{
    public function index()
    {
        try {
            $wts = WarehouseTransaction::query();

            $wts = $wts->paginate(PAGINATION);
            $products = Product::all();

            return view('pages.warehouse_transaction.index', compact('wts', 'products'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء جلب معاملات المخزن: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب معاملات المخزن. يرجى المحاولة مرة أخرى.']);
        }
    }
}
