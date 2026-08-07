<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganicAmendment;
use App\Models\OrganicAmendmentField;
use App\Models\OrganicAmendmentTranslation;
use App\Models\Seed;
use App\Models\Language;
use App\Models\Supplier;
use App\Models\Agent;
use App\Models\AllProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

class OrganicAmendmentController extends Controller
{
    // ✅ List all Organic Amendments
    public function index()
    {
        $organicAmendments = OrganicAmendment::with([
            'seed', 
            'supplier', 
            'agent', 
            'createdBy', 
            'translations.language'
        ])->get();

        return view('admin.products.organic-amendment-list', compact('organicAmendments'));
    }

public function organicAmendmentForm()
{
    $fields = OrganicAmendmentField::orderBy('id','ASC')->get();

    return view('admin.products.organic_amendment', compact('fields'));
}

    // ✅ Show create form
    public function create()
    {
        $seeds = Seed::all();
        $languages = Language::all();
        $suppliers = Supplier::all();
        $agents = Agent::all();

        return view('admin.products.organic_amendment', compact(
            'seeds', 'languages', 'suppliers', 'agents'
        ));
    }

public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'product_id' => 'nullable|integer',
        'seed_id' => 'nullable|exists:seed,id',
            'localProductName' => 'nullable|string|max:255', // 👈 ADD THIS

        'organic_type' => 'required|string|max:255',
        'physical_form' => 'required|string|max:255',
        'trade_name' => 'required|string|max:255',
        'country_origin' => 'required|string|max:255',
        'bio_label' => 'required|string|max:255',
        'n' => 'nullable|numeric',
        'p2' => 'nullable|numeric',
        'k2' => 'nullable|numeric',
        'cao' => 'nullable|numeric',
        'mgo' => 'nullable|numeric',
        'cn_ratio' => 'nullable|string|max:255',
        'raw_material' => 'nullable|array',
        'raw_material_other' => 'nullable|string|max:255',
        'arsenic_content' => 'nullable|string|max:50',
        'wholesale_price' => 'required|numeric',
        'semiwholesale_price' => 'required|numeric',
        'retail_price' => 'required|numeric',
        'supplier_id' => 'nullable|exists:suppliers,id',
        'agent_id' => 'nullable|exists:agents,id',
        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // ✅ image
    ]);

    // ✅ Default values
    $validated['created_by'] = Session::get('admin_id') ?? Auth::id() ?? 1;
    $validated['form_type']  = 'organic_amendment';
    $validated['status_id']  = 1;

    // Raw material JSON
    $validated['raw_material'] = isset($validated['raw_material'])
        ? json_encode($validated['raw_material'])
        : null;

    // Product ID resolve
    $validated['product_id'] = $request->input('product_id')
        ?? $validated['seed_id']
        ?? null;

    // ✅ Handle image upload
    if ($request->hasFile('otherRecommendationsPhoto')) {
        $image = $request->file('otherRecommendationsPhoto');
        $imageName = 'organic_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/organic'), $imageName);

        $validated['otherRecommendationsPhoto'] = 'uploads/organic/' . $imageName;
    }

    // ✅ Save ONLY Organic Amendment
    $organic = OrganicAmendment::create($validated);

    /* =========================
       QR CODE GENERATION
    ========================= */
    include_once(public_path('phpqrcode/qrlib.php'));

    $qrFolder = public_path('qrcodes');
    if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

    $qrFileName = 'organic_' . $organic->id . '.png';
    \QRcode::png(url('/organic-amendment/' . $organic->id), $qrFolder . '/' . $qrFileName, 'L', 4, 2);

    $organic->qr_code_path = 'qrcodes/' . $qrFileName;
    $organic->save();

    return redirect()->back()->with(
        'success',
        'Organic Amendment saved successfully (Status: Pending)'
    );
}

    /**
     * Helper function to safely translate a field
     */
    private function translateField($text, GoogleTranslate $tr)
    {
        try {
            return $tr->translate($text);
        } catch (\Exception $e) {
            return $text;
        }
    }
}
