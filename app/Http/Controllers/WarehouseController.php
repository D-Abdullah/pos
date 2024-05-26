<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rent;
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
                    $products = Product::whereHas('product_parties', function ($query) {
                        $query->where('type', 'rent');
                    })->orWhereDoesntHave('product_parties')->with([
                                'product_parties' => function ($query) {
                                    $query->where('type', 'rent');
                                }
                            ])->paginate(PAGINATION);

                    foreach ($products as $product) {
                        $quantity = 0;
                        foreach ($product->product_parties as $pp) {
                            $quantity -= $pp->quantity;
                        }
                        $product->quantity -= $quantity;
                    }
                    $wts = $products;
                } else if ($type == 'current') {
                    $wts = Product::with('department')->paginate(PAGINATION);
                } else if ($type == 'pp') { // products in party
                    $products = Product::whereHas('product_parties', function ($query) {
                        $query->where('type', 'rent');
                    })->with([
                                'product_parties' => function ($query) {
                                    $query->where('type', 'rent');
                                }
                            ])->paginate(PAGINATION);

                    foreach ($products as $product) {
                        $quantity = 0;
                        foreach ($product->product_parties as $pp) {
                            // Assuming there's a 'quantity' field in product_parties table
                            $quantity += $pp->quantity;
                        }
                        $product->quantity = $quantity;
                    }
                    $wts = $products;
                } else if ($type == "rp") { // rents in party
                    $products = Rent::whereHas('rent_parties', function ($query) {
                        $query->where('type', 'rent');
                    })->with([
                                'rent_parties' => function ($query) {
                                    $query->where('type', 'rent');
                                }
                            ])->paginate(PAGINATION);

                    foreach ($products as $product) {
                        $quantity = 0;
                        foreach ($product->rent_parties as $pp) {
                            // Assuming there's a 'quantity' field in rent_parties table
                            $quantity += $pp->quantity;
                        }
                        $product->quantity = $quantity;
                    }
                    $wts = $products;
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

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء عرض المخزن. يرجى المحاولة مرة أخرى.']);
        }
    }
}
