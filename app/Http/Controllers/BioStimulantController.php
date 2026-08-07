<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BioStimulant;
use App\Models\Seed;
use App\Models\Language;
use App\Models\BioStimulantTranslation;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 
use App\Models\BioStimulantsField;
class BioStimulantController extends Controller
{
    // Show the main Bio-Stimulant form page
    public function create()
    {
        $seeds = Seed::all(); // dropdown for seeds
        return view('admin.products.form_selector', compact('seeds'));
    }
public function bioStimulantsForm()
{
    $fields = \App\Models\BioStimulantsField::all();
    return view('admin.products.bio_stimulants', compact('fields'));
}



public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'product_id' => 'nullable|integer',
        'trade_name' => 'required|string|max:255',
            'localProductName' => 'nullable|string|max:255', // 👈 ADD THIS

        'physical_form' => 'required|string|max:50',
        'biostimulant_product' => 'required|string|max:100',
        're_registration' => 'required|string|max:255',
        'wholesale_price' => 'required|numeric',
        'semiwholesale_price' => 'required|numeric',
        'retail_price' => 'required|numeric',
        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $data = $request->all();

    // ✅ SET PRODUCT MASTER ID FROM HIDDEN FIELD
    $data['product_master_id'] = $request->trade_product_id;

    // Default values
    $data['created_by'] = Auth::id() ?? 1;
    $data['language_id'] = 1;
    $data['form_type'] = 'bio_stimulants';
    $data['status_id'] = 1;

    // Image upload
    if ($request->hasFile('otherRecommendationsPhoto')) {
        $image = $request->file('otherRecommendationsPhoto');
        $imageName = 'biostimulant_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/biostimulants'), $imageName);

        $data['otherRecommendationsPhoto'] = 'uploads/biostimulants/' . $imageName;
    }

    // Save
    $bio = BioStimulant::create($data);

    // QR
    include_once(public_path('phpqrcode/qrlib.php'));

    $qrFolder = public_path('qrcodes');
    if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

    $qrFileName = 'biostimulant_' . $bio->id . '.png';
    \QRcode::png(url('/bio-stimulant/' . $bio->id), $qrFolder . '/' . $qrFileName, 'L', 4, 2);

    $bio->qr_code_path = 'qrcodes/' . $qrFileName;
    $bio->save();

    return redirect()->back()->with('success', 'Saved successfully');
}

    // List all Bio-Stimulant records
    public function index()
    {
        $bioStimulants = BioStimulant::with(['seed', 'translations.language', 'supplier', 'agent'])->get();
        return view('admin.products.bio-stimulant-list', compact('bioStimulants'));
    }
}
