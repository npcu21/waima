<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MineralFertilizer;
use App\Models\MineralFertilizerTranslation;
use App\Models\Seed;
use App\Models\Language;
use App\Models\AllProduct;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

class MineralFertilizerController extends Controller
{
    // List all records
    public function index()
    {
        $fertilizers = MineralFertilizer::with(['seed', 'translations.language'])->get();
        return view('admin.products.mineral-fertilizer-list', compact('fertilizers'));
    }

    // Show create form
    public function create()
    {
        $seeds = Seed::all(); // fetch seeds for dropdown
        return view('admin.products.mineral_fertilizers', compact('seeds'));
    }

    public function minerformcreate()
{
    $fields = \App\Models\MineralFertilizerField::orderBy('id', 'asc')->get();

    return view('admin.products.mineral_fertilizers', compact('fields'));
}

   

public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'product_id' => 'required|integer',
        'fertilizer_type' => 'required|string|max:255',
            'localProductName' => 'nullable|string|max:255', // 👈 ADD THIS

        'fertilizer_registration' => 'nullable|string|max:255',
        'physical_form' => 'required|string|max:50',
        'trade_name' => 'nullable|string|max:255',
        'application_rate' => 'nullable|string|max:255',
        'n' => 'nullable|numeric',
        'p2' => 'nullable|numeric',
        'k2' => 'nullable|numeric',
        'zn' => 'nullable|numeric',
        'ca' => 'nullable|numeric',
        'mg' => 'nullable|numeric',
        's' => 'nullable|numeric',
        'b' => 'nullable|numeric',
        'mo' => 'nullable|numeric',
        'fertilizer_wholesale_price' => 'required|numeric',
        'fertilizer_semiwholesale_price' => 'required|numeric',
        'fertilizer_retail_price' => 'required|numeric',
        'supplier_id' => 'nullable|exists:suppliers,id',
        'agent_id' => 'nullable|exists:agents,id',
        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // ✅ image
    ]);

    // ✅ Default values
    $validated['created_by'] = Session::get('admin_id') ?? 1;
    $validated['form_type'] = 'mineral_fertilizer';
    $validated['status_id'] = 1;

    // ✅ Handle image upload
    if ($request->hasFile('otherRecommendationsPhoto')) {
        $image = $request->file('otherRecommendationsPhoto');
        $imageName = 'mineral_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/mineral'), $imageName);

        $validated['otherRecommendationsPhoto'] = 'uploads/mineral/' . $imageName;
    }

    // ✅ Save main Mineral Fertilizer
    $fertilizer = MineralFertilizer::create($validated);

    /* =========================
       QR CODE GENERATION
    ========================= */
    include_once(public_path('phpqrcode/qrlib.php'));

    $qrFolder = public_path('qrcodes');
    if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

    $qrFileName = 'mineral_' . $fertilizer->id . '.png';
    \QRcode::png(url('/mineral-fertilizer/' . $fertilizer->id), $qrFolder . '/' . $qrFileName, 'L', 4, 2);

    $fertilizer->qr_code_path = 'qrcodes/' . $qrFileName;
    $fertilizer->save();

    return redirect()->back()->with(
        'success',
        'Mineral fertilizer saved successfully (Status: Pending)'
    );
}

    /**
     * Helper function to translate a field safely
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
