<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WarehouseController extends Controller
{
    public function index()
    {
        try {
            DB::beginTransaction();
            $all = Product::with('department')->paginate(PAGINATION);
            DB::commit();
            return view('pages.warehouse.index', compact('all'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء عرض المخزن: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء عرض المخزن. يرجى المحاولة مرة أخرى.']);
        }
    }
}
