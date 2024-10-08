<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WarehouseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WarehouseTransactionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $rules = [
                'product' => 'nullable|exists:products,id',
                'from' => 'nullable|string',
                'to' => 'nullable|string',
                'type' => 'nullable|string',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date',
            ];

            $messages = [
                'product.exists' => 'المنتج غير موجود.',
                'from.string' => 'المخزن من غير صالح.',
                'to.string' => 'المخزن الى غير صالح.',
                'type.string' => 'النوع الى غير صالح.',
                'date_from.date' => 'تاريخ "من" غير صالح.',
                'date_to.date' => 'تاريخ "إلى" غير صالح.',
            ];

            $request->validate($rules, $messages);

            $wts = WarehouseTransaction::query();
            if ($request->filled('product')) {
                $wts->where('product_id', $request->input('product'));
            }
            if ($request->filled('from')) {
                $wts->where('from', 'LIKE', '%' . $request->input('from') . '%');
            }
            if ($request->filled('to')) {
                $wts->where('to', 'LIKE', '%' . $request->input('to') . '%');
            }
            if ($request->filled('type')) {
                $wts->where('type', 'LIKE', '%' . $request->input('type') . '%');
            }
            // Apply Date Filters
            if ($request->filled('date_from')) {
                $wts->whereDate('created_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $wts->whereDate('created_at', '<=', $request->input('date_to'));
            }

            $wts = $wts->paginate(PAGINATION);
            $products = Product::all();

            return view('pages.warehouse_transaction.index', compact('wts', 'products'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب معاملات المخزن: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب معاملات المخزن. يرجى المحاولة مرة أخرى.']);
        }
    }
}
