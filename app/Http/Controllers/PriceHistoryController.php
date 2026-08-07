<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceHistoryController extends Controller
{
    public function index()
    {
$products = DB::table('seed')
            ->where('id', '<=', 8)
            ->get();

        // Default: show ALL products graph
        $productId = 0;

        $timeRange = 180;
        $endDate = now()->toDateString();
        $startDate = now()->subDays($timeRange)->toDateString();

        return $this->loadChart($productId, $startDate, $endDate, $timeRange, $products);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|integer',
            'time_range' => 'required|integer'
        ]);

        $productId = $request->product_id ?? 0;

        $timeRange = (int) $request->time_range;

        $endDate = now()->toDateString();
        $startDate = now()->subDays($timeRange)->toDateString();

       $products = DB::table('seed')
            ->where('id', '<=', 8)
            ->get();

        return $this->loadChart($productId, $startDate, $endDate, $timeRange, $products);
    }

    private function loadChart($productId, $startDate, $endDate, $timeRange, $products)
    {
        if ($productId == 0) {
            // Load ALL PRODUCTS
            $data = DB::table('price_histories')
                ->whereBetween('changed_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->orderBy('changed_at', 'ASC')
                ->get();
        } else {
            // Load single selected product
            $data = DB::table('price_histories')
                ->where('product_id', $productId)
                ->whereBetween('changed_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->orderBy('changed_at', 'ASC')
                ->get();
        }

        $months = [];
        $wholesale = [];
        $semi = [];
        $retail = [];

        foreach ($data as $row) {
            $months[] = date('d M Y', strtotime($row->changed_at));
            $wholesale[] = $row->wholesalePrice ?? 0;
            $semi[] = $row->semiwholesalePrice ?? 0;
            $retail[] = $row->retailPrice ?? 0;
        }

        return view('price_chart', compact(
            'products',
            'productId',
            'months',
            'wholesale',
            'semi',
            'retail',
            'timeRange'
        ));
    }
}
