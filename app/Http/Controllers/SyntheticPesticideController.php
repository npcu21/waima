<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SyntheticPesticide;
use App\Models\SyntheticPesticideTranslation;
use App\Models\Seed;
use App\Models\Language;
use App\Models\AllProduct;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;

class SyntheticPesticideController extends Controller
{
    // ✅ Show all pesticides
    public function index()
    {
        $pesticides = SyntheticPesticide::with(['seed', 'supplier', 'agent', 'creator', 'translations.language'])->get();
        return view('admin.products.synthetic-pesticide-list', compact('pesticides'));
    }

    // ✅ Show create form
    public function create()
    {
        $seeds = Seed::all();
        return view('admin.products.synthetic_pesticides', compact('seeds'));
    }
    public function createform()
    {
        $fields = SyntheticcreteField::orderBy('id','ASC')->get();
        return view('admin.products.syntheticcrete', compact('fields'));
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'nullable|integer',
        'trade_name' => 'required|string|max:255',
        'active_ingredient' => 'nullable|string|max:255',
        'other_active_ingredient' => 'nullable|string|max:255',
        'formulation' => 'nullable|string|max:255',
        'registration_number' => 'required|string|max:255',
            'localProductName' => 'nullable|string|max:255', // 👈 ADD THIS

        'function' => 'nullable|string|max:255',
        'other_function' => 'nullable|string|max:255',
        'toxicological_class_number' => 'nullable|string|max:255',
        'approval_number' => 'required|string|max:255',
        'wholesale_price' => 'nullable|numeric',
        'semiwholesale_price' => 'nullable|numeric',
        'retail_price' => 'nullable|numeric',
        'seed_id' => 'nullable|exists:seed,id',
        'supplier_id' => 'nullable|integer|exists:suppliers,id',
        'agent_id' => 'nullable|integer|exists:agents,id',
        'language_id' => 'nullable|integer',
        'created_by' => 'nullable|integer',
        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // ✅ image
    ]);

    /* =========================
       DEFAULT VALUES
    ========================= */
    $validated['form_type']   = 'synthetic_pesticide';
    $validated['language_id'] = $validated['language_id'] ?? 1;
    $validated['created_by']  = $validated['created_by'] ?? (Auth::id() ?? 1);
    $validated['product_id']  = $request->input('product_id') ?? $validated['seed_id'] ?? null;

    // ✅ DEFAULT STATUS = 1 (Pending)
    $validated['status_id'] = 1;

    // ✅ Handle image upload
    if ($request->hasFile('otherRecommendationsPhoto')) {
        $image = $request->file('otherRecommendationsPhoto');
        $imageName = 'synthetic_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/synthetic'), $imageName);

        $validated['otherRecommendationsPhoto'] = 'uploads/synthetic/' . $imageName;
    }

    /* =========================
       SAVE PRODUCT ONLY
    ========================= */
    $synthetic = SyntheticPesticide::create($validated);

    /* =========================
       QR CODE GENERATION
    ========================= */
    include_once(public_path('phpqrcode/qrlib.php'));

    $qrFolder = public_path('qrcodes');
    if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

    $qrFileName = 'synthetic_' . $synthetic->id . '.png';
    \QRcode::png(url('/synthetic-pesticide/' . $synthetic->id), $qrFolder . '/' . $qrFileName, 'L', 4, 2);

    $synthetic->qr_code_path = 'qrcodes/' . $qrFileName;
    $synthetic->save();

    return redirect()->back()->with('success', 'Synthetic Pesticide saved successfully (Status: Pending)');
}




    // ✅ Safe translation helper
    private function safeTranslate($translator, $text)
    {
        try {
            return $translator->translate($text);
        } catch (\Throwable $e) {
            return $text; // fallback to original
        }
    }
}
