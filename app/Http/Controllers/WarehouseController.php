<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WarehouseController extends Controller
{
    public function index(Request $r)
    {
        try {
            DB::beginTransaction();
            wt:
            if ($r->has('type')) {
                $type = $r->input('type');
                if ($type == 'all') {
                    $wts = Product::with('department')->paginate(PAGINATION);
                } else if ($type == 'current') {
                    $wts = Product::with('department')
                        ->whereNull('party_id')
                        ->paginate(PAGINATION);

                } else if ($type == 'party') {
                    $wts = Product::with('department')
                        ->whereNotNull('party_id')
                        ->paginate(PAGINATION);

                }
            } else {
                $r->merge(['type' => 'all']);
                goto wt;
            }
            DB::commit();
            return view('pages.warehouse.index', compact('wts'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء عرض المخزن: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء عرض المخزن. يرجى المحاولة مرة أخرى.' . $e->getMessage()]);
        }
    }
}
