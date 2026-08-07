<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VeterinaryProduct;
use App\Models\VeterinaryProductTranslation;
use App\Models\AllProduct;
use App\Models\Seed;
use App\Models\Language;
use App\Models\Supplier;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;

class VeterinaryProductController extends Controller
{
    // Show all veterinary products
    public function index()
    {
        $veterinaryProducts = VeterinaryProduct::with(['seed','supplier','agent','creator','translations.language'])->get();
        return view('admin.products.veterinary-product-list', compact('veterinaryProducts'));
    }

    // Show create form
    public function create()
    {
        $seeds = Seed::all();
        $languages = Language::all();
        $suppliers = Supplier::all();
        $agents = Agent::all();

        return view('admin.products.veterinary_products', compact('seeds','languages','suppliers','agents'));
    }


    public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'product_id' => 'required|integer',
        'title' => 'nullable|string|max:255',
        'product_name' => 'required|string|max:255',
        'manufacturing_lab' => 'nullable|string|max:255',
        'active_substance' => 'nullable|string|max:255',
        'registration_number' => 'required|string|max:255',
        'therapeutic_class' => 'nullable|string|max:255',
        'other_therapeutic_class' => 'nullable|string|max:255',
        'dosage' => 'nullable|string|max:255',
        'pharmaceutical_form' => 'nullable|string|max:255',
        'route_of_administration' => 'nullable|string|max:255',
            'localProductName' => 'nullable|string|max:255', // 👈 ADD THIS

        'targeted_animals' => 'nullable|string|max:255',
        'waiting_period' => 'nullable|string|max:255',
        'expiry_date' => 'nullable|date',
        'transport_storage_requirements' => 'nullable|string|max:255',
        'wholesale_price' => 'required|numeric',
        'semiwholesale_price' => 'required|numeric',
        'retail_price' => 'required|numeric',
        'seed_id' => 'nullable|exists:seed,id',
        'supplier_id' => 'nullable|exists:suppliers,id',
        'agent_id' => 'nullable|exists:agents,id',
        'language_id' => 'nullable|integer',
        'created_by' => 'nullable|integer',
        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // ✅ image
    ]);

    /* =========================
       DEFAULT VALUES
    ========================= */
    $validated['form_type']  = 'veterinary_product';
    $validated['language_id'] = $validated['language_id'] ?? 1;
    $validated['created_by']  = $validated['created_by'] ?? (Auth::id() ?? 1);
    $validated['product_id']  = $request->input('product_id') ?? $validated['seed_id'] ?? null;

    // ✅ DEFAULT STATUS = 1 (Pending)
    $validated['status_id'] = 1;

    // ✅ Handle image upload
    if ($request->hasFile('otherRecommendationsPhoto')) {
        $image = $request->file('otherRecommendationsPhoto');
        $imageName = 'veterinary_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/veterinary'), $imageName);

        $validated['otherRecommendationsPhoto'] = 'uploads/veterinary/' . $imageName;
    }

    /* =========================
       SAVE MAIN PRODUCT
    ========================= */
    $veterinary = VeterinaryProduct::create($validated);

    /* =========================
       QR CODE GENERATION
    ========================= */
    include_once(public_path('phpqrcode/qrlib.php'));

    $qrFolder = public_path('qrcodes');
    if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

    $qrFileName = 'veterinary_' . $veterinary->id . '.png';
    \QRcode::png(url('/veterinary-product/' . $veterinary->id), $qrFolder . '/' . $qrFileName, 'L', 4, 2);

    $veterinary->qr_code_path = 'qrcodes/' . $qrFileName;
    $veterinary->save();

    // ✅ Removed translations
    return redirect()->back()->with('success', 'Veterinary Product added successfully!');
}



    private function safeTranslate($translator, $text)
    {
        try {
            return $translator->translate($text);
        } catch (\Throwable $e) {
            return $text;
        }
    }
}
