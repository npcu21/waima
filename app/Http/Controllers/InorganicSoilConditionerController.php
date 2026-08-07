<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InorganicSoilConditioner;
use App\Models\InorganicSoilConditionerField;
use App\Models\InorganicSoilConditionerTranslation;
use App\Models\Seed;
use App\Models\Language;
use App\Models\AllProduct;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

class InorganicSoilConditionerController extends Controller
{
    // Show form
    public function create()
    {
        $seeds = Seed::all();
        return view('admin.products.inorganic_soil_conditioners', compact('seeds'));
    }
    public function inorganicForm()
{
    $fields = \App\Models\InorganicSoilConditionerField::orderBy('id', 'asc')->get();

    return view('admin.products.inorganic_soil_conditioners', compact('fields'));
}

    // List all records
    public function index()
    {
        $conditioners = InorganicSoilConditioner::with(['seed', 'translations.language'])->get();
        return view('admin.products.inorganic-soil-conditioner-list', compact('conditioners'));
    }

    
public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'product_id' => 'nullable|integer',
        'conditioner_type' => 'required|string|max:255',
            'localProductName' => 'nullable|string|max:255', // 👈 ADD THIS

        'physical_form' => 'required|string|max:50',
        'trade_name' => 'required|string|max:255',
        'raw_material' => 'nullable|string|max:255',
        'other' => 'nullable|string|max:255',
        'function' => 'nullable|string|max:255',
        'wholesale_price' => 'required|numeric',
        'semiwholesale_price' => 'required|numeric',
        'retail_price' => 'required|numeric',
        'supplier_id' => 'nullable|integer|exists:suppliers,id',
        'agent_id' => 'nullable|integer|exists:agents,id',
        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // ✅ image
    ]);

    // Default values
    $validated['created_by'] = Session::get('admin_id') ?? 1;
    $validated['form_type']  = 'inorganic_soil_conditioner';
    $validated['status_id']  = 1; // Pending

    // Product ID
    $validated['product_id'] = $request->input('product_id');

    // ✅ Handle image upload
    if ($request->hasFile('otherRecommendationsPhoto')) {
        $image = $request->file('otherRecommendationsPhoto');
        $imageName = 'inorganic_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/inorganic'), $imageName);

        $validated['otherRecommendationsPhoto'] = 'uploads/inorganic/' . $imageName;
    }

    // Save main record
    $conditioner = InorganicSoilConditioner::create($validated);

    /* =========================
       QR CODE GENERATION
    ========================= */
    include_once(public_path('phpqrcode/qrlib.php'));

    $qrFolder = public_path('qrcodes');
    if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

    $qrFileName = 'inorganic_' . $conditioner->id . '.png';
    \QRcode::png(url('/inorganic-soil-conditioner/' . $conditioner->id), $qrFolder . '/' . $qrFileName, 'L', 4, 2);

    $conditioner->qr_code_path = 'qrcodes/' . $qrFileName;
    $conditioner->save();

    return redirect()->back()->with(
        'success',
        'Inorganic Soil Conditioner saved successfully (Status: Pending)'
    );
}


}
