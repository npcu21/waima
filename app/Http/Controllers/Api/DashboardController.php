<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnimalFeed;
use App\Models\BioStimulant;
use App\Models\InorganicSoilConditioner;
use App\Models\MineralFertilizer;
use App\Models\OrganicAmendment;
use App\Models\SeedForm;
use App\Models\SyntheticPesticide;
use App\Models\VeterinaryProduct;
use App\Models\Image;
use App\Models\Supplier;
use App\Models\FarmerEnquiry;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    // ============================================
    //           ADMIN / GENERAL DASHBOARD
    // ============================================
    public function dashboard(Request $request)
    {
        $user = null;
        if ($request->user_id) {
            $user = User::find($request->user_id);
        }

        $totalCount =
            AnimalFeed::count() +
            BioStimulant::count() +
            InorganicSoilConditioner::count() +
            MineralFertilizer::count() +
            OrganicAmendment::count() +
            SeedForm::count() +
            SyntheticPesticide::count() +
            VeterinaryProduct::count();

        $supplierCount = Supplier::count();
        $totalFarmerEnquiries = FarmerEnquiry::count();

        $baseUrl = 'https://fivoflow.com/wclm/public/uploads/';

        $images = Image::all()->map(function ($image) use ($baseUrl) {

            $imagePaths = json_decode($image->image_path, true);

            if (is_array($imagePaths)) {
                $formattedPaths = array_map(function ($path) use ($baseUrl) {
                    return strpos($path, $baseUrl) === false ? $baseUrl . $path : $path;
                }, $imagePaths);
            } else {
                $formattedPaths = strpos($image->image_path, $baseUrl) === false
                    ? [$baseUrl . $image->image_path]
                    : [$image->image_path];
            }

            return [
                'id' => $image->id,
                'name' => $image->name,
                'image_paths' => $formattedPaths
            ];
        });

        return response()->json([
            'success' => true,
            'user' => $user,
            'total_products' => $totalCount,
            'supplier_count' => $supplierCount,
            'total_farmer_enquiries' => $totalFarmerEnquiries,
            'images' => $images
        ]);
    }

    // ============================================
    //             FARMER DASHBOARD
    // ============================================
//     public function farmerDashboard(Request $request)
// {
//     if (!$request->user_id) {
//         return response()->json(['success' => false, 'message' => 'user_id is required'], 400);
//     }

//     $user = User::find($request->user_id);

//     if (!$user) {
//         return response()->json(['success' => false, 'message' => 'User not found'], 404);
//     }

//     // Get supplier IDs for user's country
//     $supplierIds = Supplier::where('country_id', $user->country_id)->pluck('id')->toArray();
//     $supplierCount = count($supplierIds);

//     // Array of product models
//     $productModels = [
//         AnimalFeed::class,
//         BioStimulant::class,
//         InorganicSoilConditioner::class,
//         MineralFertilizer::class,
//         OrganicAmendment::class,
//         SeedForm::class,
//         SyntheticPesticide::class,
//         VeterinaryProduct::class,
//     ];

//     // Total products with status_id = 2
//     $totalCount = 0;
//     foreach ($productModels as $model) {
//         $query = $model::where('status_id', 2);

//         // If supplier IDs exist, filter by them
//         if (!empty($supplierIds)) {
//             $query->whereIn('supplier_id', $supplierIds);
//         }

//         $totalCount += $query->count();
//     }

//     // Total farmer enquiries created by this user
//     $totalFarmerEnquiries = FarmerEnquiry::where('created_by', $user->id)->count();

//     // ============================
//     // IMAGE PATHS
//     // ============================
//     $baseUrl = "https://fivoflow.com/wclm/public/uploads/";

//     $images = Image::all()->map(function ($image) use ($baseUrl) {
//         $paths = json_decode($image->image_path, true);
//         if (!is_array($paths)) {
//             $paths = [$image->image_path];
//         }

//         return [
//             'id' => $image->id,
//             'name' => $image->name,
//             'image_paths' => array_map(function ($p) use ($baseUrl) {
//                 if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) {
//                     return $p;
//                 }
//                 return $baseUrl . ltrim($p, '/');
//             }, $paths)
//         ];
//     });

//     return response()->json([
//         'success' => true,
//         'user' => $user,
//         'total_products' => $totalCount,
//         'supplier_count' => $supplierCount,
//         'total_farmer_enquiries' => $totalFarmerEnquiries,
//         'images' => $images
//     ]);
// }
// public function farmerDashboard(Request $request)
// {
//     // ============================
//     // IMAGE PATHS (COMMON)
//     // ============================
//     $baseUrl = "https://fivoflow.com/wclm/public/uploads/";

//     $images = Image::all()->map(function ($image) use ($baseUrl) {
//         $paths = json_decode($image->image_path, true);
//         if (!is_array($paths)) {
//             $paths = [$image->image_path];
//         }

//         return [
//             'id' => $image->id,
//             'name' => $image->name,
//             'image_paths' => array_map(function ($p) use ($baseUrl) {
//                 if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) {
//                     return $p;
//                 }
//                 return $baseUrl . ltrim($p, '/');
//             }, $paths)
//         ];
//     });

//     // ==================================================
//     // 🔹 CASE 1: user_id NOT PROVIDED → ONLY IMAGES
//     // ==================================================
//     if (!$request->user_id) {
//         return response()->json([
//             'success' => true,
//             'images' => $images
//         ]);
//     }

//     // ==================================================
//     // 🔹 CASE 2: user_id PROVIDED → FULL DASHBOARD
//     // ==================================================
//     $user = User::find($request->user_id);

//     if (!$user) {
//         return response()->json([
//             'success' => false,
//             'message' => 'User not found'
//         ], 404);
//     }

//     // Supplier IDs based on user's country
//     $supplierIds = Supplier::where('country_id', $user->country_id)
//         ->pluck('id')
//         ->toArray();

//     $supplierCount = count($supplierIds);

//     // Product models
//     $productModels = [
//         AnimalFeed::class,
//         BioStimulant::class,
//         InorganicSoilConditioner::class,
//         MineralFertilizer::class,
//         OrganicAmendment::class,
//         SeedForm::class,
//         SyntheticPesticide::class,
//         VeterinaryProduct::class,
//     ];

//     // Total products with status_id = 2
//     $totalCount = 0;
//     foreach ($productModels as $model) {
//         $query = $model::where('status_id', 2);

//         if (!empty($supplierIds)) {
//             $query->whereIn('supplier_id', $supplierIds);
//         }

//         $totalCount += $query->count();
//     }

//     // Farmer enquiries
//     $totalFarmerEnquiries = FarmerEnquiry::where('created_by', $user->id)->count();

//     return response()->json([
//         'success' => true,
//         'user' => $user,
//         'total_products' => $totalCount,
//         'supplier_count' => $supplierCount,
//         'total_farmer_enquiries' => $totalFarmerEnquiries,
//         'images' => $images
//     ]);
// }
// public function farmerDashboard(Request $request)
// {
//     if (!$request->user_id) {
//         return response()->json(['success' => false, 'message' => 'user_id is required'], 400);
//     }

//     $user = User::find($request->user_id);

//     if (!$user) {
//         return response()->json(['success' => false, 'message' => 'User not found'], 404);
//     }

//     // ============================
//     // SUPPLIER COUNT (COUNTRY BASED)
//     // ============================
//     $supplierCount = Supplier::where('country_id', $user->country_id)->count();

//     // ============================
//     // PRODUCT MODELS
//     // ============================
//     $productModels = [
//         AnimalFeed::class,
//         BioStimulant::class,
//         InorganicSoilConditioner::class,
//         MineralFertilizer::class,
//         OrganicAmendment::class,
//         SeedForm::class,
//         SyntheticPesticide::class,
//         VeterinaryProduct::class,
//     ];

//     // ============================
//     // TOTAL PRODUCTS (ONLY status_id = 2)
//     // ============================
//     $totalCount = 0;

//     foreach ($productModels as $model) {
//         $totalCount += $model::where('status_id', 2)->count();
//     }

//     // ============================
//     // FARMER ENQUIRIES
//     // ============================
//     $totalFarmerEnquiries = FarmerEnquiry::where('created_by', $user->id)->count();

//     // ============================
//     // IMAGES
//     // ============================
//     $baseUrl = "https://fivoflow.com/wclm/public/uploads/";

//     $images = Image::all()->map(function ($image) use ($baseUrl) {

//         $paths = json_decode($image->image_path, true);
//         if (!is_array($paths)) {
//             $paths = [$image->image_path];
//         }

//         return [
//             'id' => $image->id,
//             'name' => $image->name,
//             'image_paths' => array_map(function ($p) use ($baseUrl) {
//                 return str_starts_with($p, 'http')
//                     ? $p
//                     : $baseUrl . ltrim($p, '/');
//             }, $paths)
//         ];
//     });

//     // ============================
//     // FINAL RESPONSE (UNCHANGED)
//     // ============================
//     return response()->json([
//         'success' => true,
//         'user' => $user,
//         'total_products' => $totalCount,
//         'supplier_count' => $supplierCount,
//         'total_farmer_enquiries' => $totalFarmerEnquiries,
//         'images' => $images
//     ]);
// } live code 
public function farmerDashboard(Request $request)
{
    // ============================
    // USER (OPTIONAL)
    // ============================
    $user = null;
    if ($request->user_id) {
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    }

    // ============================
    // SUPPLIER COUNT (COUNTRY BASED IF USER EXISTS)
    // ============================
    if ($user) {
        $supplierCount = Supplier::where('country_id', $user->country_id)->count();
    } else {
        $supplierCount = Supplier::count(); // total suppliers
    }

    // ============================
    // PRODUCT MODELS
    // ============================
    $productModels = [
        AnimalFeed::class,
        BioStimulant::class,
        InorganicSoilConditioner::class,
        MineralFertilizer::class,
        OrganicAmendment::class,
        SeedForm::class,
        SyntheticPesticide::class,
        VeterinaryProduct::class,
    ];

    // ============================
    // TOTAL PRODUCTS (status_id = 2)
    // ============================
    $totalCount = 0;
    foreach ($productModels as $model) {
        $totalCount += $model::where('status_id', 2)->count();
    }

    // ============================
    // FARMER ENQUIRIES (USER-SPECIFIC IF EXISTS)
    // ============================
    if ($user) {
        $totalFarmerEnquiries = FarmerEnquiry::where('created_by', $user->id)->count();
    } else {
        $totalFarmerEnquiries = FarmerEnquiry::count();
    }

    // ============================
    // IMAGES
    // ============================
    $baseUrl = "https://fivoflow.com/wclm/public/uploads/";

    $images = Image::all()->map(function ($image) use ($baseUrl) {
        $paths = json_decode($image->image_path, true);
        if (!is_array($paths)) {
            $paths = [$image->image_path];
        }

        return [
            'id' => $image->id,
            'name' => $image->name,
            'image_paths' => array_map(function ($p) use ($baseUrl) {
                return str_starts_with($p, 'http')
                    ? $p
                    : $baseUrl . ltrim($p, '/');
            }, $paths)
        ];
    });

    // ============================
    // FINAL RESPONSE
    // ============================
    return response()->json([
        'success' => true,
        'user' => $user,
        'total_products' => $totalCount,
        'supplier_count' => $supplierCount,
        'total_farmer_enquiries' => $totalFarmerEnquiries,
        'images' => $images
    ]);
}



public function agentDashboard(Request $request)
{
    try {

        if (!$request->agent_id) {
            return response()->json(['success' => false, 'message' => 'agent_id is required'], 400);
        }

        $agent = Agent::find($request->agent_id);

        if (!$agent) {
            return response()->json(['success' => false, 'message' => 'Agent not found'], 404);
        }

        // ============================
        // PRODUCT MODELS LIST
        // ============================
        $tables = [
            SeedForm::class,
            VeterinaryProduct::class,
            SyntheticPesticide::class,
            MineralFertilizer::class,
            OrganicAmendment::class,
            InorganicSoilConditioner::class,
            AnimalFeed::class,
            BioStimulant::class,
        ];

        // ============================
        // TOTAL PRODUCTS BY AGENT
        // ============================
        $totalProducts = 0;

        foreach ($tables as $model) {
            $tableName = (new $model)->getTable();

            if (\Schema::hasColumn($tableName, 'agent_id')) {
                $totalProducts += $model::where('agent_id', $agent->id)->count();
            }
        }

        // ============================
        // TOTAL SUPPLIERS BY AGENT COUNTRY
        // ============================
       $totalSuppliers = \DB::table('suppliers')
    ->where('created_by', $agent->id)
    ->count();
        // ============================
        // IMAGES (all, full URL)
        // ============================
        $baseUrl = 'https://fivoflow.com/wclm/public/uploads/';

        $images = \App\Models\Image::all()->map(function ($image) use ($baseUrl) {

            $paths = json_decode($image->image_path, true);
            if (!is_array($paths)) {
                $paths = [$image->image_path];
            }

            return [
                'id' => $image->id,
                'name' => $image->name,

                // FIXED HERE — prevents double URL
                'image_paths' => array_map(function ($p) use ($baseUrl) {

                    // If already full URL → return as is
                    if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) {
                        return $p;
                    }

                    // If relative path → add base URL
                    return $baseUrl . ltrim($p, '/');

                }, $paths)
            ];
        });

        // ============================
        // RESPONSE
        // ============================
     return response()->json([
    'success' => true,
    'agent' => $agent,
    'total_products' => $totalProducts,
    'supplier_count' => $totalSuppliers,
    'images' => $images
]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}



}
