<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeedForm;
use App\Models\SeedFormTranslation;
use App\Models\Language;
use App\Models\Supplier;
use App\Models\Agent;
use App\Models\AllProduct;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\DB;


class SeedFormController extends Controller
{


public function store(Request $request)
{
    $validated = $request->validate([
        'cropName' => 'required|string|max:255',
        'verityName' => 'required|string|max:255',
        'breederName' => 'nullable|string|max:255',
        'countryOrigin' => 'nullable|string|max:255',
        'registrationNumber' => 'required|string|max:255',
        'varietyType' => 'nullable|string|max:255',
        'seedCategory' => 'nullable|string|max:255',
        'precocity' => 'nullable|string|max:255',
        'fruitColor' => 'nullable|string|max:255',
        'fruitShape' => 'nullable|string|max:255',
        'leafLength' => 'nullable|string|max:255',
        'leafColor' => 'nullable|string|max:255',
        'plantHeight' => 'nullable|string|max:255',
        'plantHabit' => 'nullable|string|max:255',
        'bioticResistance' => 'nullable|string|max:255',
        'abioticResistance' => 'nullable|string|max:255',
        'InherentNutritionalValue' => 'nullable|string',
        'other' => 'nullable|string',
            'localProductName' => 'nullable|string|max:255', // 👈 ADD THIS

        'yield' => 'nullable|string',
        'otherRecommendations' => 'nullable|string',
        'wholesalePrice' => 'nullable|numeric',
        'semiwholesalePrice' => 'nullable|numeric',
        'retailPrice' => 'nullable|numeric',
        'supplier_id' => 'nullable|integer',
        'agent_id' => 'nullable|integer',
        'title' => 'nullable|string|max:255',
    ]);

    // ✅ Default values
    $validated['title'] = $validated['title'] ?? $request->cropName;
    $validated['language_id'] = 1;
    $validated['form_type'] = 'seed_form';
    $validated['created_by'] = Auth::id() ?? 1;
    $validated['status_id'] = 1;

    // =========================
    // ✅ PRODUCT AUTO CREATE / FIND
    // =========================
    $productName = trim($request->cropName);

    $product = DB::table('products')
        ->whereRaw('LOWER(name) = ?', [strtolower($productName)])
        ->first();

    if (!$product) {
        $productId = DB::table('products')->insertGetId([
            'name' => $productName
        ]);
    } else {
        $productId = $product->id;
    }

    // ✅ IMPORTANT (ONLY THIS)
    $validated['product_id'] = $productId;

    // =========================

    // ✅ File upload
    if ($request->hasFile('otherRecommendationsPhoto')) {
        $validated['otherRecommendationsPhoto'] =
            $request->file('otherRecommendationsPhoto')->store('seed_photos', 'public');
    }

    // ✅ Save seed form
    $seedForm = SeedForm::create($validated);

    // =========================
    // ✅ QR CODE GENERATE
    // =========================
    include_once(public_path('phpqrcode/qrlib.php'));

    $qrFolder = public_path('qrcodes');
    if (!file_exists($qrFolder)) {
        mkdir($qrFolder, 0755, true);
    }

    $qrFileName = 'seedform_' . $seedForm->id . '.png';

    \QRcode::png(
        url('/seed-form/' . $seedForm->id),
        $qrFolder . '/' . $qrFileName,
        'L',
        4,
        2
    );

    $seedForm->qr_code_path = 'qrcodes/' . $qrFileName;
    $seedForm->save();

    return redirect()->back()->with('success', 'Seed Form saved successfully (Status: Pending)');
}


    // ✅ Show create form
    public function create()
    {
        $languages = Language::all();
        $suppliers = Supplier::all();
        $agents = Agent::all();

        return view('admin.products.seed_form', compact('languages', 'suppliers', 'agents'));
    }
    public function seedform()
{
    $fields = \App\Models\SeedField::orderBy('order_no', 'asc')->get();

    return view('admin.products.seed', compact('fields'));
}

public function getProductSuggestions(Request $request)
{
    $search = trim($request->search);

    if (!$search) {
        return response()->json([]);
    }

    // ✅ PRODUCTS (no supplier_id here)
    $products = DB::table('products')
        ->where('name', 'like', '%' . $search . '%')
        ->select('id', 'name', DB::raw('NULL as supplier_id'))
        ->get();

    // ✅ SEEDS
    $seeds = DB::table('seed_forms')
        ->where('cropName', 'like', '%' . $search . '%')
        ->select(
            DB::raw('NULL as id'),
            DB::raw('cropName as name'),
            'supplier_id'
        )
        ->get();

    // ✅ ANIMAL FEED
    $animalFeeds = DB::table('animal_feeds')
        ->where('afrm', 'like', '%' . $search . '%')
        ->select(
            DB::raw('NULL as id'),
            DB::raw('afrm as name'),
            'supplier_id'
        )
        ->get();

    // ✅ BIO STIMULANTS
    $bio = DB::table('bio_stimulants')
        ->where('trade_name', 'like', '%' . $search . '%')
        ->select(
            'id',
            DB::raw('trade_name as name'),
            'supplier_id'
        )
        ->get();

    // ✅ MINERAL
    $mineral = DB::table('mineral_fertilizers')
        ->where('trade_name', 'like', '%' . $search . '%')
        ->select(
            'id',
            DB::raw('trade_name as name'),
            'supplier_id'
        )
        ->get();

    // ✅ INORGANIC
    $inorganic = DB::table('inorganic_soil_conditioners')
        ->where('trade_name', 'like', '%' . $search . '%')
        ->select(
            'id',
            DB::raw('trade_name as name'),
            'supplier_id'
        )
        ->get();

    // ✅ ORGANIC
    $organic = DB::table('organic_amendments')
        ->where('trade_name', 'like', '%' . $search . '%')
        ->select(
            'id',
            DB::raw('trade_name as name'),
            'supplier_id'
        )
        ->get();

    // ✅ SYNTHETIC
    $synthetic = DB::table('synthetic_pesticides')
        ->where('trade_name', 'like', '%' . $search . '%')
        ->select(
            'id',
            DB::raw('trade_name as name'),
            'supplier_id'
        )
        ->get();

    // ✅ VETERINARY
    $veterinary = DB::table('veterinary_products')
        ->where('product_name', 'like', '%' . $search . '%')
        ->select(
            'id',
            DB::raw('product_name as name'),
            'supplier_id'
        )
        ->get();

    // ✅ MERGE ALL
    $results = collect()
        ->merge($products)
        ->merge($seeds)
        ->merge($animalFeeds)
        ->merge($bio)
        ->merge($mineral)
        ->merge($inorganic)
        ->merge($organic)
        ->merge($synthetic)
        ->merge($veterinary)
        ->filter(function ($item) {
            return !empty($item->name);
        })
        ->unique(function ($item) {
            return $item->name . '-' . $item->supplier_id;
        })
        ->values();

    return response()->json($results);
}
// public function getProductSuggestions(Request $request)
// {
//     $search = trim($request->search);

//     if (!$search) {
//         return response()->json([]);
//     }

//     // ✅ PRODUCTS
//     $products = DB::table('products')
//         ->where('name', 'like', '%' . $search . '%')
//         ->select('id', 'name')
//         ->get();

//     // ✅ SEEDS (NO ID → FAKE ID NULL)
//     $seeds = DB::table('seed_forms')
//         ->where('cropName', 'like', '%' . $search . '%')
//         ->select(DB::raw('NULL as id'), DB::raw('cropName as name'))
//         ->get();

//     // ✅ ANIMAL FEED
//     $animalFeeds = DB::table('animal_feeds')
//         ->where('afrm', 'like', '%' . $search . '%')
//         ->select(DB::raw('NULL as id'), DB::raw('afrm as name'))
//         ->get();

//     // ✅ BIO STIMULANTS
//     $bio = DB::table('bio_stimulants')
//         ->where('trade_name', 'like', '%' . $search . '%')
//         ->select('id', DB::raw('trade_name as name'))
//         ->get();

//     // ✅ MINERAL FERTILIZERS (🔥 NEW ADD)
//     $mineral = DB::table('mineral_fertilizers')
//         ->where('trade_name', 'like', '%' . $search . '%')
//         ->select('id', DB::raw('trade_name as name'))
//         ->get();
//           // INORGANIC
//     $inorganic = DB::table('inorganic_soil_conditioners')
//         ->where('trade_name', 'like', '%' . $search . '%')
//         ->select('id', DB::raw('trade_name as name'))
//         ->get();
//         $organic = DB::table('organic_amendments')
//         ->where('trade_name', 'like', '%' . $search . '%')
//         ->select('id', DB::raw('trade_name as name'))
//         ->get();
//         // ✅ SYNTHETIC PESTICIDES (NEW)
// $synthetic = DB::table('synthetic_pesticides')
//     ->where('trade_name', 'like', '%' . $search . '%')
//     ->select('id', DB::raw('trade_name as name'))
//     ->get();
//     // ✅ VETERINARY PRODUCTS (NEW)
// $veterinary = DB::table('veterinary_products')
//     ->where('product_name', 'like', '%' . $search . '%')
//     ->select('id', DB::raw('product_name as name'))
//     ->get();

//     // ✅ MERGE ALL (same format)
//     $results = collect()
//         ->merge($products)
//         ->merge($seeds)
//         ->merge($animalFeeds)
//         ->merge($bio)
//         ->merge($mineral)
//         ->merge($inorganic)
//         ->merge($organic)
//         ->merge($synthetic)
//         ->merge($veterinary)
//         ->filter(function ($item) {
//             return !empty($item->name);
//         })
//         ->unique('name') // duplicate remove by name
//         ->values();

//     return response()->json($results);
// }
// public function getProductSuggestions(Request $request)
// {
//     $search = trim($request->search);

//     if (!$search) {
//         return response()->json([]);
//     }

//     // Products table
//     $products = DB::table('products')
//         ->where('name', 'like', '%' . $search . '%')
//         ->pluck('name');

//     // Seed table (already working)
//     $seeds = DB::table('seed_forms')
//         ->where('cropName', 'like', '%' . $search . '%')
//         ->pluck('cropName');

//     // ✅ Animal Feed (NEW)
//     $animalFeeds = DB::table('animal_feeds')
//         ->where('afrm', 'like', '%' . $search . '%')
//         ->pluck('afrm');

//             // ✅ BIO STIMULANTS TABLE (NEW 🔥)
//     $bio = DB::table('bio_stimulants')
//         ->where('trade_name', 'like', '%' . $search . '%')
//         ->select('id', DB::raw('trade_name as name'))
//         ->get();

//     // Merge all
//     $results = $products
//         ->merge($seeds)
//         ->merge($animalFeeds)
//         ->merge($bio)
//         ->filter()          // remove null / empty
//         ->unique()          // remove duplicates
//         ->values();

//     return response()->json($results);
// }
   


    // Helper function to safely translate a field
    private function translateField($text, GoogleTranslate $tr)
    {
        try {
            return $tr->translate($text);
        } catch (\Exception $e) {
            return $text;
        }
    }
}
