<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceHistory;

class PriceHistoryController extends Controller
{
//   public function getPriceHistoryByDate(Request $request)
// {
//     // Validate inputs
//     $request->validate([
//         'product_id' => 'required',
//         'date' => 'required|date'
//     ]);

//     // Get ALL older records including given date
//     $history = PriceHistory::where('product_id', $request->product_id)
//         ->whereDate('changed_at', '<=', $request->date)
//         ->orderBy('changed_at', 'DESC')
//         ->get();

//     if ($history->isEmpty()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'No price history found'
//         ]);
//     }

//     return response()->json([
//         'status' => true,
//         'count'  => $history->count(),
//         'data'   => $history
//     ]);
// }
// public function getPriceHistoryByDate(Request $request)
// {
//     // Validate
//     $request->validate([
//         'product_id' => 'required',
//         'date'       => 'nullable|date',
//         'from_date'  => 'nullable|date',
//         'to_date'    => 'nullable|date'
//     ]);

//     $query = PriceHistory::where('product_id', $request->product_id);

//     // If single date provided → show all records <= that date
//     if ($request->filled('date')) {
//         $query->whereDate('changed_at', '<=', $request->date);
//     }

//     // Date range filter (from_date to to_date)
//     if ($request->filled('from_date') && $request->filled('to_date')) {
//         $query->whereBetween('changed_at', [
//             $request->from_date,
//             $request->to_date
//         ]);
//     }

//     // If only from_date given → show >= from_date
//     if ($request->filled('from_date') && !$request->filled('to_date')) {
//         $query->whereDate('changed_at', '>=', $request->from_date);
//     }

//     // If only to_date given → show <= to_date
//     if ($request->filled('to_date') && !$request->filled('from_date')) {
//         $query->whereDate('changed_at', '<=', $request->to_date);
//     }

//     $history = $query->orderBy('changed_at', 'DESC')->get();

//     if ($history->isEmpty()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'No price history found'
//         ]);
//     }

//     return response()->json([
//         'status' => true,
//         'count'  => $history->count(),
//         'data'   => $history
//     ]);
// }
// public function getPriceHistoryByDate(Request $request)
// {
//     // Validate
//     $request->validate([
//         'product_id' => 'required|integer',
//         'date'       => 'nullable|date',
//         'from_date'  => 'nullable|date',
//         'to_date'    => 'nullable|date',
//     ]);

//     // Base query for the product
//     $query = PriceHistory::where('product_id', $request->product_id);

//     // Single date filter
//     if ($request->filled('date')) {
//         $query->whereDate('changed_at', '=', $request->date);
//     }

//     // Date range filter
//     if ($request->filled('from_date') && $request->filled('to_date')) {
//         $query->whereBetween('changed_at', [$request->from_date, $request->to_date]);
//     } elseif ($request->filled('from_date')) {
//         $query->whereDate('changed_at', '>=', $request->from_date);
//     } elseif ($request->filled('to_date')) {
//         $query->whereDate('changed_at', '<=', $request->to_date);
//     }

//     // Fetch the data
//     $history = $query->orderBy('changed_at', 'DESC')->get();

//     if ($history->isEmpty()) {
//         return response()->json([
//             'status'  => false,
//             'message' => 'No price history found for this product'
//         ]);
//     }

//     return response()->json([
//         'status' => true,
//         'count'  => $history->count(),
//         'data'   => $history
//     ]);
// }
// public function getPriceHistoryByDate(Request $request)
// {
//     // Validate
//     $request->validate([
//         'product_id' => 'required|integer',
//         'date'       => 'nullable|date',
//         'from_date'  => 'nullable|date',
//         'to_date'    => 'nullable|date',
//     ]);

//     $productId = $request->product_id;

//     // Base query for the product
//     $query = PriceHistory::where('product_id', $productId);

//     // Single date filter
//     if ($request->filled('date')) {
//         $query->whereDate('changed_at', '=', $request->date);
//     }

//     // Date range filter
//     if ($request->filled('from_date') && $request->filled('to_date')) {
//         $query->whereBetween('changed_at', [$request->from_date, $request->to_date]);
//     } elseif ($request->filled('from_date')) {
//         $query->whereDate('changed_at', '>=', $request->from_date);
//     } elseif ($request->filled('to_date')) {
//         $query->whereDate('changed_at', '<=', $request->to_date);
//     }

//     // Fetch the data
//     $history = $query->orderBy('changed_at', 'DESC')->get();

//     if ($history->isEmpty()) {
//         return response()->json([
//             'status'     => false,
//             'product_id' => $productId,
//             'message'    => 'No price history found for this product',
//             'data'       => []
//         ]);
//     }

//     // Map data to custom format (without product_id inside each item)
//     $formatted = $history->map(function($item) {
//         return [
//             'price_date'      => $item->changed_at->format('Y-m-d'),
//             'whole_sale_price'=> (float) $item->wholesalePrice,
//             'retail_price'    => (float) $item->retailPrice,
//         ];
//     });

//     return response()->json([
//         'status'     => true,
//         'product_id' => $productId,
//         'message'    => 'Filtered successfully',
//         'data'       => $formatted
//     ]);
// }

 public function getPriceHistoryByDate(Request $request)
    {
        // Validate
        $request->validate([
            'product_id' => 'required|integer',
            'from_date'  => 'nullable|date',
            'to_date'    => 'nullable|date',
        ]);

        $productId = $request->product_id;

        $query = PriceHistory::where('add_product_id', $productId);

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('changed_at', [$request->from_date, $request->to_date]);
        } elseif ($request->filled('from_date')) {
            $query->whereDate('changed_at', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $query->whereDate('changed_at', '<=', $request->to_date);
        }

        $history = $query->orderBy('changed_at', 'DESC')->get();

        if ($history->isEmpty()) {
            return response()->json([
                'status'     => false,
                'product_id' => $productId,
                'message'    => 'No price history found for this product',
                'data'       => []
            ]);
        }

        $formatted = $history->map(function($item) {
            return [
                'price_date'          => $item->changed_at->format('Y-m-d'),
                'whole_sale_price'    => (float) $item->wholesalePrice,
                'semi_wholesale_price'=> (float) $item->semiwholesalePrice,
                'retail_price'        => (float) $item->retailPrice,
            ];
        });

        return response()->json([
            'status'     => true,
            'product_id' => $productId,
            'message'    => 'Filtered successfully',
            'data'       => $formatted
        ]);
    }
}




