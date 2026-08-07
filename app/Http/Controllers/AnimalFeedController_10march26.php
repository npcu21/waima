<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnimalFeed;
use App\Models\Language;
use App\Models\AnimalFeedTranslation;
use Illuminate\Support\Facades\Session;
use App\Models\AnimalFeedField;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\Agent;
use App\Models\SeedFieldsEnglishFrench;
use Stichoza\GoogleTranslate\GoogleTranslate;
// check

class AnimalFeedController extends Controller
{
    // Show the form selector page
    public function create()
    {
        return view('admin.products.form_selector');
    }

    // Return suppliers (optionally filtered by country_id)
    public function getSuppliers(Request $request)
    {
        try {
            $countryId = $request->query('country_id');

            if ($countryId) {
                $suppliers = Supplier::where('country_id', $countryId)->select('id','company_name','country_id')->get();
            } else {
                $suppliers = Supplier::select('id','company_name','country_id')->get();
            }

            return response()->json($suppliers, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch suppliers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Return agents (optionally filtered by country_id)
    public function getAgents(Request $request)
    {
        try {
            $countryId = $request->query('country_id');

            if ($countryId) {
                $agents = Agent::where('country_id', $countryId)->select('id','name','country_id')->get();
            } else {
                $agents = Agent::select('id','name','country_id')->get();
            }

            return response()->json($agents, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch agents',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Return countries list
    public function getCountries()
    {
        try {
            $countries = Country::select('id','name')->get();
            return response()->json($countries, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch countries',
                'error' => $e->getMessage()
            ], 500);
        }
    }




















// public function getFormFields($product_id)
// {
//     try {
//         $fields = SeedFieldsEnglishFrench::where('product_id', $product_id)->get();

//         return response()->json([
//             'success' => true,
//             'fields' => $fields
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'error' => $e->getMessage()
//         ], 500);
//     }
// }
// public function getSuppliers()
// {
//     $suppliers = Supplier::all();
//     return response()->json($suppliers);
// }

// public function getAgents()
// {
//     $agents = Agent::all();
//     return response()->json($agents);
// }
// public function animalFeedForm()
// {
//     $fields = \DB::table('animal_feed_fields')->get();

//     return view('admin.products.animalfeed', compact('fields'));
// }



    // Store the submitted form data
//     public function store(Request $request)
// {
//     $validated = $request->validate([
//         'form_type' => 'required|string|max:255',
//         'product_id' => 'nullable|integer', // <-- fixed
//         'Typeoffeed' => 'nullable|string|max:255',
//         'afrm' => 'nullable|string|max:255',
//         'afPhysicalform' => 'nullable|string|max:255',
//         'afdm' => 'nullable|string|max:255',
//         'afEnergy' => 'nullable|string|max:255',
//         'afcp' => 'nullable|string|max:255',
//         'afsp' => 'nullable|string|max:255',
//         'affs' => 'nullable|string|max:255',
//         'afWholesalePrice' => 'nullable|numeric',
//         'afsemiwholesalePrice' => 'nullable|numeric',
//         'afretailPrice' => 'nullable|numeric',
//         'supplier_id' => 'nullable|integer',
//         'agent_id' => 'nullable|integer',
//     ]);

//     // Use logged-in user instead of session
//     $validated['created_by'] = auth()->id() ?? 1; // fallback to 1 for testing

//     // Save record
//     $animalFeed = AnimalFeed::create($validated);

//     if($animalFeed){
//         return redirect()->back()->with('success', 'Animal Feed saved successfully!');
//     } else {
//         return redirect()->back()->with('error', 'Failed to save Animal Feed.');
//     }
// }
// public function store(Request $request)
// {
//     $validated = $request->validate([
//         'form_type' => 'required|string|max:255',
//         'product_id' => 'nullable|integer',
//         'Typeoffeed' => 'nullable|string|max:255',
//         'afrm' => 'nullable|string|max:255',
//         'afPhysicalform' => 'nullable|string|max:255',
//         'afdm' => 'nullable|string|max:255',
//         'afEnergy' => 'nullable|string|max:255',
//         'afcp' => 'nullable|string|max:255',
//         'afsp' => 'nullable|string|max:255',
//         'affs' => 'nullable|string|max:255',
//         'afWholesalePrice' => 'nullable|numeric',
//         'afsemiwholesalePrice' => 'nullable|numeric',
//         'afretailPrice' => 'nullable|numeric',
//         'supplier_id' => 'nullable|integer',
//         'agent_id' => 'nullable|integer',
//     ]);

//     // ✅ Default values
//     $validated['created_by'] = auth()->id() ?? 1;
//     $validated['status_id'] = 1; // default status = 1

//     // ✅ Save main Animal Feed
//     $animalFeed = AnimalFeed::create($validated);

//     /* =========================
//        QR CODE GENERATION
//     ========================= */
//     include_once(public_path('phpqrcode/qrlib.php'));

//     $qrFolder = public_path('qrcodes');
//     if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

//     $qrFileName = 'animalfeed_' . $animalFeed->id . '.png';
//     \QRcode::png(url('/animal-feed/' . $animalFeed->id), $qrFolder . '/' . $qrFileName, 'L', 4, 2);

//     $animalFeed->qr_code_path = 'qrcodes/' . $qrFileName;
//     $animalFeed->save();

//     return redirect()->back()->with('success', 'Animal Feed saved successfully (Status: Pending)');
// }
public function store(Request $request)
{
    $validated = $request->validate([
        'form_type' => 'required|string|max:255',
        'product_id' => 'nullable|integer',
        'Typeoffeed' => 'nullable|string|max:255',
        'afrm' => 'nullable|string|max:255',
        'afPhysicalform' => 'nullable|string|max:255',
        'afdm' => 'nullable|string|max:255',
        'afEnergy' => 'nullable|string|max:255',
        'afcp' => 'nullable|string|max:255',
        'afsp' => 'nullable|string|max:255',
        'affs' => 'nullable|string|max:255',
        'afWholesalePrice' => 'nullable|numeric',
        'afsemiwholesalePrice' => 'nullable|numeric',
        'afretailPrice' => 'nullable|numeric',
        'supplier_id' => 'nullable|integer',
        'agent_id' => 'nullable|integer',
        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // ✅ match DB column
    ]);

    // Default values
    $validated['created_by'] = auth()->id() ?? 1;
    $validated['status_id'] = 1; // default status = 1

    // Handle image upload
    if ($request->hasFile('otherRecommendationsPhoto')) {
        $image = $request->file('otherRecommendationsPhoto');
        $imageName = 'animalfeed_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/animalfeeds'), $imageName);

        // ✅ Save to the correct DB column
        $validated['otherRecommendationsPhoto'] = 'uploads/animalfeeds/' . $imageName;
    }

    // Save main Animal Feed
    $animalFeed = AnimalFeed::create($validated);

    /* =========================
       QR CODE GENERATION
    ========================= */
    include_once(public_path('phpqrcode/qrlib.php'));

    $qrFolder = public_path('qrcodes');
    if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

    $qrFileName = 'animalfeed_' . $animalFeed->id . '.png';
    \QRcode::png(url('/animal-feed/' . $animalFeed->id), $qrFolder . '/' . $qrFileName, 'L', 4, 2);

    $animalFeed->qr_code_path = 'qrcodes/' . $qrFileName;
    $animalFeed->save();

    return redirect()->back()->with('success', 'Animal Feed saved successfully (Status: Pending)');
}



    // List all feeds
    public function index()
    {
        $feeds = AnimalFeed::with(['creator', 'translations.language'])->get();
        return view('admin.products.animal-feed-list', compact('feeds'));
    }



    public function createCountryForm()
{
    return view('admin.products.form_selector');
}

// // ==============================================
// // RETURN SUPPLIERS (Filtered by Country)
// // ==============================================
// public function getCountrySuppliers(Request $request)
// {
//     try {
//         $countryId = $request->query('country_id');

//         if ($countryId) {
//             $suppliers = Supplier::where('country_id', $countryId)
//                 ->select('id','company_name','country_id')
//                 ->get();
//         } else {
//             $suppliers = Supplier::select('id','company_name','country_id')->get();
//         }

//         return response()->json($suppliers, 200);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Failed to fetch suppliers',
//             'error' => $e->getMessage()
//         ], 500);
//     }
// }

// // ==============================================
// // RETURN AGENTS (Filtered by Country)
// // ==============================================
// public function getCountryAgents(Request $request)
// {
//     try {
//         $countryId = $request->query('country_id');

//         if ($countryId) {
//             $agents = Agent::where('country_id', $countryId)
//                 ->select('id','name','country_id')
//                 ->get();
//         } else {
//             $agents = Agent::select('id','name','country_id')->get();
//         }

//         return response()->json($agents, 200);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Failed to fetch agents',
//             'error' => $e->getMessage()
//         ], 500);
//     }
// }

// // ==============================================
// // RETURN COUNTRIES
// // ==============================================
// public function getCountryList()
// {
//     try {
//         $countries = Country::select('id','name')->get();
//         return response()->json($countries, 200);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Failed to fetch countries',
//             'error' => $e->getMessage()
//         ], 500);
//     }
// }
// ==============================================
// RETURN SUPPLIERS (Filtered by Country)
// ==============================================
// Suppliers
public function getCountrySuppliers(Request $request)
{
    $countryId = $request->query('country_id');

    // Fallback to logged-in user only if available
    if (!$countryId && auth()->check()) {
        $countryId = auth()->user()->country_id;
    }

    $suppliers = Supplier::when($countryId, function($q, $cid){
        $q->where('country_id', $cid);
    })->select('id','company_name')->get();

    return response()->json($suppliers);
}

public function getCountryAgents(Request $request)
{
    $countryId = $request->query('country_id');

    // Fallback to logged-in user only if available
    if (!$countryId && auth()->check()) {
        $countryId = auth()->user()->country_id;
    }

    $agents = Agent::when($countryId, function($q, $cid){
        $q->where('country_id', $cid);
    })->select('id','name')->get();

    return response()->json($agents);
}



// ==============================================
// RETURN COUNTRIES
// ==============================================
public function getCountryList()
{
    try {
        $countries = Country::select('id','name')->get();
        return response()->json($countries, 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch countries',
            'error' => $e->getMessage()
        ], 500);
    }
}


}
