<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Exception;
use App\Models\SeedForm;
use App\Models\AnimalFeed;
use App\Models\BioStimulant;
use App\Models\Language;
use App\Models\Notification;
use App\Models\AnimalFeedTranslation;
use App\Models\InorganicSoilConditioner;
use App\Models\InorganicSoilConditionerTranslation;
use App\Models\MineralFertilizer;
use App\Models\OrganicAmendment;
use App\Models\SyntheticPesticide;
use App\Models\VeterinaryProduct;
use App\Models\AllProduct; 
use App\Models\ProductLike;

// use SimpleSoftwareIO\QrCode\Facades\QrCode;
// ✅ Import AllProduct
use Illuminate\Support\Facades\DB;  // ✅ Add this line
use Illuminate\Support\Facades\Schema;

class CommonProductApiController extends Controller
{
    

public function store(Request $request)
{
    $productId = $request->input('product_id');
    $recordId = $request->input('id'); // check if update request

    if (!$productId) {
        return response()->json([
            'status' => false,
            'message' => 'product_id is required.'
        ], 400);
    }

    try {
        switch ($productId) {
            case 8: // Seed Forms
                $savedData = $this->storeSeedForm($request, $recordId);
                break;
            case 2: // Animal Feeds
                $savedData = $this->storeAnimalFeed($request, $recordId);
                break;
            case 5: // Bio Stimulants
                $savedData = $this->storeBioStimulant($request, $recordId);
                break;
            case 4: // Inorganic Soil Conditioners
                $savedData = $this->storeInorganicSoilConditioner($request, $recordId);
                break;
            case 7: // Mineral Fertilizers
                $savedData = $this->storeMineralFertilizer($request, $recordId);
                break;
            case 6: // Organic Amendments
                $savedData = $this->storeOrganicAmendment($request, $recordId);
                break;
            case 3: // Synthetic Pesticides
                $savedData = $this->storeSyntheticPesticide($request, $recordId);
                break;
            case 1: // Veterinary Products
                $savedData = $this->storeVeterinaryProduct($request, $recordId);
                break;
            default:
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid product_id.'
                ], 400);
        }

        if ($savedData instanceof \Illuminate\Http\JsonResponse) {
            $json = $savedData->getData(true);
            $savedData = $json['data'] ?? null;
        }

        return response()->json([
            'status' => true,
            'message' => $recordId ? 'Data updated successfully.' : 'Data saved successfully.',
            'product_id' => $productId,
            'id' => $savedData->id ?? null,
            'data' => $savedData
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error saving/updating data.',
            'error' => $e->getMessage()
        ], 500);
    }
}

// live code
private function storeSeedForm(Request $request, $id = null) 
{
    // ----------------- VALIDATION -----------------
    $validated = $request->validate([
        'product_id' => 'nullable|integer',
        'cropName' => 'required|string|max:255',
            'localProductName' => 'nullable|string|max:255', // ✅ ADD THIS
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
        'InherentNutritionalValue' => 'required|string',
        'other' => 'nullable|string',
        'yield' => 'nullable|string',
        'otherRecommendations' => 'nullable|string',
        'wholesalePrice' => 'nullable|numeric',
        'semiwholesalePrice' => 'nullable|numeric',
        'retailPrice' => 'nullable|numeric',
        'supplier_id' => 'nullable|integer',
        'agent_id' => 'nullable|integer',
        'created_by' => 'nullable|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    // ----------------- DEFAULT VALUES -----------------
    $validated['agent_id']   = $request->input('agent_id', 1);
    $validated['language_id'] = 1;
    $validated['form_type']   = 'seed_form';
    $validated['product_id'] = $request->input('product_id');
    $userId = $request->input('created_by', Auth::id() ?? 1);

    // ----------------- IMAGE UPLOAD -----------------
    if ($request->hasFile('otherRecommendationsPhoto')) {
        $file = $request->file('otherRecommendationsPhoto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = 'uploads/seed_images/' . $filename;
        $file->move(public_path('uploads/seed_images'), $filename);
        $validated['otherRecommendationsPhoto'] = $filePath;
    } elseif ($id) {
        $oldSeed = SeedForm::find($id);
        if ($oldSeed) {
            $validated['otherRecommendationsPhoto'] = $oldSeed->otherRecommendationsPhoto;
        }
    }

    // =====================================================
    // ================= UPDATE MODE =======================
    // =====================================================
    if ($id) {

        $oldSeedForm = SeedForm::find($id);

        if (!$oldSeedForm) {
            return response()->json([
                'status' => false,
                'message' => 'Seed form not found.'
            ], 404);
        }

        // ⭐ Parent ID (original record)
        $validated['parent_id'] = $oldSeedForm->parent_id ?? $oldSeedForm->id;

        // ⭐ UPDATED ENTRY SHOULD BE PENDING
        $validated['status_id'] = 1; // Pending

        // ⭐ Created by
        $validated['created_by'] = $userId;

        // ⭐ INSERT NEW ROW (DUPLICATE)
        $seedForm = SeedForm::create($validated);

        // ⭐ PRICE HISTORY
        \DB::table('price_histories')->insert([
            'product_id'         => $oldSeedForm->product_id,
            'supplier_id'        => $oldSeedForm->supplier_id,
            'wholesalePrice'     => $oldSeedForm->wholesalePrice,
            'semiwholesalePrice' => $oldSeedForm->semiwholesalePrice,
            'retailPrice'        => $oldSeedForm->retailPrice,
            'updated_by'         => $userId,
            'add_product_id'     => $seedForm->id,
            'changed_at'         => now(),
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        $message = 'Seed form updated. New pending entry created.';
    }

    // =====================================================
    // ================= CREATE MODE =======================
    // =====================================================
    else {

        // ⭐ Normal create (first entry)
        $validated['status_id'] = 2; // Approved / Active (agar aapke system me alag ho to change kare)

        $seedForm = SeedForm::create($validated);

        Notification::create([
            'title'   => 'New Product Added',
            'message' => "Product {$request->cropName} - {$request->verityName} added.",
            'is_read' => 0,
        ]);

        // ⭐ First price log
        \DB::table('price_histories')->insert([
            'product_id'         => $seedForm->product_id,
            'supplier_id'        => $seedForm->supplier_id,
            'wholesalePrice'     => $seedForm->wholesalePrice,
            'semiwholesalePrice' => $seedForm->semiwholesalePrice,
            'retailPrice'        => $seedForm->retailPrice,
            'updated_by'         => $userId,
            'add_product_id'     => $seedForm->id,
            'changed_at'         => now(),
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        $message = 'Seed form created successfully.';
    }

    // ----------------- QR CODE -----------------
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

    return response()->json([
        'status'  => true,
        'message' => $message,
        'data'    => $seedForm
    ], $id ? 200 : 201);
}



    


// live code h
private function storeAnimalFeed(Request $request, $id = null) 
{
    // ======================================================
    // VALIDATION
    // ======================================================
    $validated = $request->validate([
        'product_id' => 'nullable|integer',
            'localProductName' => 'nullable|string|max:255', // ✅ ADD THIS
        'Typeoffeed' => 'nullable|string|max:255',
        'title' => 'nullable|string|max:255',
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
        'created_by' => 'nullable|integer',

        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // ======================================================
    // DEFAULT VALUES
    // ======================================================
    $validated['agent_id']    = $request->input('agent_id', 1);
    $validated['language_id'] = 1;
    $validated['form_type']   = 'animal_feed';
    $validated['product_id']  = $request->input('product_id');

    $userId = $request->input('created_by', Auth::id() ?? 1);

    try {

        // ======================================================
        // UPDATE MODE → NEW PENDING ENTRY
        // ======================================================
        if ($id) {

            $oldFeed = AnimalFeed::find($id);

            if (!$oldFeed) {
                return response()->json([
                    'status' => false,
                    'message' => 'Animal feed record not found.'
                ], 404);
            }

            // ⭐ parent_id (original record)
            $validated['parent_id'] = $oldFeed->parent_id ?? $oldFeed->id;

            // ⭐ UPDATED ENTRY SHOULD BE PENDING
            $validated['status_id'] = 1; // Pending

            // ⭐ Created by
            $validated['created_by'] = $userId;

            // ⭐ IMAGE (new image ya old image)
            if ($request->hasFile('otherRecommendationsPhoto')) {
                $img = $request->file('otherRecommendationsPhoto');
                $folder = public_path('uploads/animal_feeds');
                if (!file_exists($folder)) mkdir($folder, 0755, true);

                $imgName = 'animal_feed_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                $img->move($folder, $imgName);

                $validated['otherRecommendationsPhoto'] = 'uploads/animal_feeds/' . $imgName;
            } else {
                $validated['otherRecommendationsPhoto'] = $oldFeed->otherRecommendationsPhoto;
            }

            // ⭐ INSERT NEW ROW (NO UPDATE)
            $animalFeed = AnimalFeed::create($validated);

            // ⭐ PRICE HISTORY
            \DB::table('price_histories')->insert([
                'product_id'         => $oldFeed->product_id,
                'supplier_id'        => $oldFeed->supplier_id,
                'wholesalePrice'     => $oldFeed->afWholesalePrice,
                'semiwholesalePrice' => $oldFeed->afsemiwholesalePrice,
                'retailPrice'        => $oldFeed->afretailPrice,
                'updated_by'         => $userId,
                'add_product_id'     => $animalFeed->id,
                'changed_at'         => now(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            $message = 'Animal feed updated. New pending entry created.';
        }

        // ======================================================
        // CREATE MODE
        // ======================================================
        else {

            if ($request->hasFile('otherRecommendationsPhoto')) {
                $img = $request->file('otherRecommendationsPhoto');
                $folder = public_path('uploads/animal_feeds');
                if (!file_exists($folder)) mkdir($folder, 0755, true);

                $imgName = 'animal_feed_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                $img->move($folder, $imgName);

                $validated['otherRecommendationsPhoto'] = 'uploads/animal_feeds/' . $imgName;
            }

            // ⭐ FIRST ENTRY → APPROVED / ACTIVE
            $validated['status_id'] = 2; // agar aapke system me alag ho to change kare

            $animalFeed = AnimalFeed::create($validated);

            Notification::create([
                'title'   => 'New Animal Feed Added',
                'message' => "Animal Feed {$request->title} has been added.",
                'is_read' => 0,
            ]);

            \DB::table('price_histories')->insert([
                'product_id'         => $animalFeed->product_id,
                'supplier_id'        => $animalFeed->supplier_id,
                'wholesalePrice'     => $animalFeed->afWholesalePrice,
                'semiwholesalePrice' => $animalFeed->afsemiwholesalePrice,
                'retailPrice'        => $animalFeed->afretailPrice,
                'updated_by'         => $userId,
                'add_product_id'     => $animalFeed->id,
                'changed_at'         => now(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            $message = 'Animal feed created successfully.';
        }

        // ======================================================
        // QR CODE
        // ======================================================
        include_once(public_path('phpqrcode/qrlib.php'));

        $qrFolder = public_path('qrcodes');
        if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

        $qrFileName = 'animalfeed_' . $animalFeed->id . '.png';
        \QRcode::png(
            url('/animalfeed/' . $animalFeed->id),
            $qrFolder . '/' . $qrFileName,
            'L',
            4,
            2
        );

        $animalFeed->qr_code_path = 'qrcodes/' . $qrFileName;
        $animalFeed->save();

        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $animalFeed
        ], $id ? 200 : 201);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Failed to save Animal Feed',
            'error'   => $e->getMessage()
        ], 500);
    }
}




// live code 
private function storeBioStimulant(Request $request) 
{
    \DB::beginTransaction();

    try {

        // ================= VALIDATION =================
        $validated = $request->validate([
            'id'                   => 'nullable|integer',
            'product_id'           => 'required|integer',
                'localProductName' => 'nullable|string|max:255', // ✅ ADD THIS
            'trade_name'           => 'required|string|max:255',
            'physical_form'        => 'required|string|max:50',
            'biostimulant_product' => 'required|string|max:100',
            're_registration'      => 'required|string|max:255',

            'n'  => 'nullable|numeric',
            'p2' => 'nullable|numeric',
            'k2' => 'nullable|numeric',
            'zn' => 'nullable|numeric',
            'ca' => 'nullable|numeric',
            'mg' => 'nullable|numeric',
            's'  => 'nullable|numeric',
            'b'  => 'nullable|numeric',
            'mo' => 'nullable|numeric',

            'action_mode'         => 'nullable|string|max:255',
            'wholesale_price'     => 'required|numeric',
            'semiwholesale_price' => 'required|numeric',
            'retail_price'        => 'required|numeric',

            'supplier_id' => 'nullable|integer',
            'agent_id'    => 'nullable|integer',

            'otherRecommendationsPhoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        // ================= COMMON DATA =================
        $validated['created_by']  = Auth::id() ?? 1;
        $validated['language_id'] = 1;
        $validated['form_type']   = 'bio_stimulant';
        $validated['status_id']   = 1; // ✅ ALWAYS PENDING

        // ================= UPDATE CASE =================
        if (!empty($validated['id'])) {

            $parentBio = BioStimulant::findOrFail($validated['id']);

            // -------- OLD PRICE HISTORY --------
            \DB::table('price_histories')->insert([
                'product_id'         => $parentBio->product_id,
                'supplier_id'        => $parentBio->supplier_id,
                'wholesalePrice'     => $parentBio->wholesale_price,
                'semiwholesalePrice' => $parentBio->semiwholesale_price,
                'retailPrice'        => $parentBio->retail_price,
                'updated_by'         => $validated['created_by'],
                'add_product_id'     => $parentBio->id,
                'changed_at'         => now(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // -------- NEW PENDING RECORD --------
            $newBioData = collect($validated)
                ->except(['id', 'otherRecommendationsPhoto'])
                ->toArray();

            $newBioData['parent_id'] = $parentBio->id;

            $bio = BioStimulant::create($newBioData);

        } 
        // ================= CREATE CASE =================
        else {

            $bio = BioStimulant::create(
                collect($validated)->except('otherRecommendationsPhoto')->toArray()
            );
        }

        // ================= NEW PRICE HISTORY =================
        \DB::table('price_histories')->insert([
            'product_id'         => $bio->product_id,
            'supplier_id'        => $bio->supplier_id,
            'wholesalePrice'     => $bio->wholesale_price,
            'semiwholesalePrice' => $bio->semiwholesale_price,
            'retailPrice'        => $bio->retail_price,
            'updated_by'         => $validated['created_by'],
            'add_product_id'     => $bio->id,
            'changed_at'         => now(),
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        // ================= IMAGE UPLOAD =================
        if ($request->hasFile('otherRecommendationsPhoto')) {

            $file = $request->file('otherRecommendationsPhoto');
            $folder = public_path('uploads/bio_stimulant');

            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            $fileName = 'bio_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($folder, $fileName);

            $bio->otherRecommendationsPhoto = 'uploads/bio_stimulant/' . $fileName;
            $bio->save();
        }

        // ================= QR CODE =================
        include_once(public_path('phpqrcode/qrlib.php'));

        $qrDir = public_path('qrcodes');
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0755, true);
        }

        $qrName = 'bio_' . $bio->id . '.png';

        \QRcode::png(
            url('/bio-stimulant/' . $bio->id),
            $qrDir . '/' . $qrName,
            'L',
            4,
            2
        );

        $bio->qr_code_path = 'qrcodes/' . $qrName;
        $bio->save();

        \DB::commit();

        return response()->json([
            'status'  => true,
            'message' => empty($validated['id'])
                ? 'Bio Stimulant created (Pending)'
                : 'Bio Stimulant update sent for approval (Pending)',
            'data' => $bio
        ], empty($validated['id']) ? 201 : 200);

    } catch (\Exception $e) {

        \DB::rollBack();

        return response()->json([
            'status'  => false,
            'message' => 'Failed to save Bio Stimulant',
            'error'   => $e->getMessage()
        ], 500);
    }
}





// ilve code h ye 

private function storeInorganicSoilConditioner(Request $request) 
{
    \DB::beginTransaction();

    try {

        // ======================================================
        // MAP POSTMAN KEYS
        // ======================================================
        if ($request->has('semi_wholesale_price')) {
            $request->merge(['semiwholesale_price' => $request->input('semi_wholesale_price')]);
        }
        if ($request->has('other_raw_material')) {
            $request->merge(['other' => $request->input('other_raw_material')]);
        }

        // ======================================================
        // VALIDATION
        // ======================================================
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'product_id' => 'required|integer',
                'localProductName' => 'nullable|string|max:255', // ✅ ADD THIS
            'conditioner_type' => 'required|string|max:255',
            'physical_form' => 'required|string|max:50',
            'trade_name' => 'required|string|max:255',
            'raw_material' => 'nullable|string|max:255',
            'other' => 'nullable|string|max:255',
            'function' => 'nullable|string|max:255',
            'wholesale_price' => 'required|numeric',
            'semiwholesale_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
            'supplier_id' => 'nullable|integer',
            'agent_id' => 'nullable|integer',
            'otherRecommendationsPhoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ======================================================
        // COMMON DATA
        // ======================================================
        $validated['created_by'] = Auth::id() ?? 1;
        $validated['form_type']  = 'inorganic_soil_conditioner';
        $validated['status_id'] = 1; // ✅ ALWAYS PENDING

        $userId = $validated['created_by'];

        // ======================================================
        // UPDATE (CREATE NEW PENDING RECORD)
        // ======================================================
        if (!empty($validated['id'])) {

            $parent = InorganicSoilConditioner::findOrFail($validated['id']);

            // -------- OLD PRICE HISTORY --------
            \DB::table('price_histories')->insert([
                'product_id'         => $parent->product_id,
                'supplier_id'        => $parent->supplier_id,
                'wholesalePrice'     => $parent->wholesale_price,
                'semiwholesalePrice' => $parent->semiwholesale_price,
                'retailPrice'        => $parent->retail_price,
                'updated_by'         => $userId,
                'add_product_id'     => $parent->id,
                'changed_at'         => now(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            $newData = collect($validated)
                ->except(['id', 'otherRecommendationsPhoto'])
                ->toArray();

            $newData['parent_id'] = $parent->id;

            $conditioner = InorganicSoilConditioner::create($newData);

        } 
        // ======================================================
        // CREATE
        // ======================================================
        else {

            $conditioner = InorganicSoilConditioner::create(
                collect($validated)->except('otherRecommendationsPhoto')->toArray()
            );
        }

        // ======================================================
        // NEW PRICE HISTORY
        // ======================================================
        \DB::table('price_histories')->insert([
            'product_id'         => $conditioner->product_id,
            'supplier_id'        => $conditioner->supplier_id,
            'wholesalePrice'     => $conditioner->wholesale_price,
            'semiwholesalePrice' => $conditioner->semiwholesale_price,
            'retailPrice'        => $conditioner->retail_price,
            'updated_by'         => $userId,
            'add_product_id'     => $conditioner->id,
            'changed_at'         => now(),
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        // ======================================================
        // IMAGE UPLOAD
        // ======================================================
        if ($request->hasFile('otherRecommendationsPhoto')) {

            $img = $request->file('otherRecommendationsPhoto');
            $folder = public_path('uploads/inorganic_soil_conditioner');

            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            $imgName = 'inorganic_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move($folder, $imgName);

            $conditioner->otherRecommendationsPhoto =
                'uploads/inorganic_soil_conditioner/' . $imgName;

            $conditioner->save();
        }

        // ======================================================
        // QR CODE
        // ======================================================
        include_once(public_path('phpqrcode/qrlib.php'));

        $qrPath = public_path('qrcodes');
        if (!file_exists($qrPath)) {
            mkdir($qrPath, 0755, true);
        }

        $qrFile = 'inorganic_' . $conditioner->id . '.png';

        \QRcode::png(
            url('/inorganic-soil-conditioner/' . $conditioner->id),
            $qrPath . '/' . $qrFile,
            'L',
            4,
            2
        );

        $conditioner->qr_code_path = 'qrcodes/' . $qrFile;
        $conditioner->save();

        \DB::commit();

        return response()->json([
            'status'  => true,
            'message' => empty($validated['id'])
                ? 'Inorganic Soil Conditioner created (Pending)'
                : 'Update sent for approval (Pending)',
            'data' => $conditioner
        ], empty($validated['id']) ? 201 : 200);

    } catch (\Exception $e) {

        \DB::rollBack();

        return response()->json([
            'status'  => false,
            'message' => 'Failed to save Inorganic Soil Conditioner',
            'error'   => $e->getMessage()
        ], 500);
    }
}


// live code

private function storeMineralFertilizer(Request $request)  
{
    DB::beginTransaction();

    try {
        // ================= VALIDATION =================
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'product_id' => 'required|integer',
                'localProductName' => 'nullable|string|max:255', // ✅ ADD THIS
            'fertilizer_type' => 'required|string|max:255',

            'fertilizer_wholesale_price' => 'required|numeric',
            'fertilizer_semiwholesale_price' => 'required|numeric',
            'fertilizer_retail_price' => 'required|numeric',

            'title' => 'nullable|string|max:255',
            'fertilizer_registration' => 'nullable|string|max:255',
            'physical_form' => 'nullable|string|max:50',
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

            'supplier_id' => 'nullable|integer',
            'agent_id' => 'nullable|integer',

            'otherRecommendationsPhoto' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ================= COMMON DATA =================
        $validated['form_type']  = 'mineral_fertilizer';
        $validated['language_id'] = 1;
        $validated['created_by'] = Auth::id() ?? 1;
        $validated['status_id'] = 1; // ✅ ALWAYS PENDING
        $userId = $validated['created_by'];

        // ================= UPDATE =================
        if (!empty($validated['id'])) {

            $parent = MineralFertilizer::findOrFail($validated['id']);

            // OLD PRICE HISTORY
            DB::table('price_histories')->insert([
                'product_id' => $parent->product_id,
                'supplier_id' => $parent->supplier_id,
                'wholesalePrice' => $parent->fertilizer_wholesale_price,
                'semiwholesalePrice' => $parent->fertilizer_semiwholesale_price,
                'retailPrice' => $parent->fertilizer_retail_price,
                'updated_by' => $userId,
                'add_product_id' => $parent->id,
                'changed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $newData = collect($validated)
                ->except(['id', 'otherRecommendationsPhoto'])
                ->toArray();
            $newData['parent_id'] = $parent->id;

            $fertilizer = MineralFertilizer::create($newData);

            // ================= NOTIFICATION =================
            Notification::create([
                'title' => 'Product Update Pending',
                'message' => "Product {$fertilizer->title} update sent for approval.",
                'is_read' => 0,
            ]);

        } else {
            // ================= CREATE =================
            $fertilizer = MineralFertilizer::create(
                collect($validated)->except('otherRecommendationsPhoto')->toArray()
            );

            // ================= NOTIFICATION =================
            Notification::create([
                'title' => 'New Product Added',
                'message' => "Product {$fertilizer->title} added.",
                'is_read' => 0,
            ]);
        }

        // ================= NEW PRICE HISTORY =================
        DB::table('price_histories')->insert([
            'product_id' => $fertilizer->product_id,
            'supplier_id' => $fertilizer->supplier_id,
            'wholesalePrice' => $fertilizer->fertilizer_wholesale_price,
            'semiwholesalePrice' => $fertilizer->fertilizer_semiwholesale_price,
            'retailPrice' => $fertilizer->fertilizer_retail_price,
            'updated_by' => $userId,
            'add_product_id' => $fertilizer->id,
            'changed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ================= IMAGE =================
        if ($request->hasFile('otherRecommendationsPhoto')) {

            $img = $request->file('otherRecommendationsPhoto');
            $folder = public_path('uploads/mineral_fertilizer');
            if (!file_exists($folder)) mkdir($folder, 0755, true);

            $imgName = 'fertilizer_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move($folder, $imgName);

            $fertilizer->otherRecommendationsPhoto = 'uploads/mineral_fertilizer/' . $imgName;
            $fertilizer->save();
        }

        // ================= QR CODE =================
        include_once(public_path('phpqrcode/qrlib.php'));
        $qrFolder = public_path('qrcodes');
        if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

        $qrFile = 'fertilizer_' . $fertilizer->id . '.png';
        \QRcode::png(
            url('/mineral-fertilizer/' . $fertilizer->id),
            $qrFolder . '/' . $qrFile,
            'L',
            4,
            2
        );

        $fertilizer->qr_code_path = 'qrcodes/' . $qrFile;
        $fertilizer->save();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => empty($validated['id'])
                ? 'Mineral Fertilizer created (Pending)'
                : 'Update sent for approval (Pending)',
            'data' => $fertilizer
        ], empty($validated['id']) ? 201 : 200);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => 'Mineral Fertilizer save failed',
            'error' => $e->getMessage()
        ], 500);
    }
}





// live code h 
private function storeOrganicAmendment(Request $request) {

    $validated = $request->validate([
        'id' => 'nullable|integer',
        'product_id' => 'nullable|integer',
        'organic_type' => 'required|string|max:255',
            'localProductName' => 'nullable|string|max:255', // ✅ ADD THIS
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
        'copper_content' => 'nullable|string|max:10',
        'chromium_content' => 'nullable|string|max:10',
        'lead_content' => 'nullable',

        'wholesale_price' => 'required|numeric',
        'semiwholesale_price' => 'required|numeric',
        'retail_price' => 'required|numeric',
        'supplier_id' => 'nullable|integer',
        'agent_id' => 'nullable|integer',
        'status_id' => 'nullable|integer',
        'created_by' => 'nullable|integer',
        'language_id' => 'nullable|integer',

        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // ✅ updated key
    ]);

    // ---------- Yes/No → 1/0 ----------
    if ($request->lead_content == "Yes") {
        $validated['lead_content'] = 1;
    } elseif ($request->lead_content == "No") {
        $validated['lead_content'] = 0;
    } else {
        $validated['lead_content'] = null;
    }

    // ---------- DEFAULT VALUES ----------
    $validated['language_id'] = $request->input('language_id', 1);
    $validated['form_type'] = 'organic_amendment';
    $validated['created_by'] = $request->input('created_by', Auth::id() ?? 1);
    $validated['raw_material'] = json_encode($validated['raw_material'] ?? []);
    $validated['product_id'] = $request->input('product_id');
    $validated['agent_id'] = $request->input('agent_id', 1);

    // ---------- STATUS ----------
    if ($request->filled('supplier_id')) {
        $validated['status_id'] = 1;
    } elseif ($request->filled('agent_id') && !$request->filled('supplier_id')) {
        $validated['status_id'] = 4;
    } else {
        $validated['status_id'] = 1;
    }

    // ---------- UPDATE ----------
    if (!empty($validated['id'])) {

        $organic = OrganicAmendment::find($validated['id']);
        if (!$organic) {
            return response()->json(['error' => 'Organic amendment not found.'], 404);
        }

        \DB::table('price_histories')->insert([
            'product_id' => $organic->product_id,
            'supplier_id' => $organic->supplier_id,
            'wholesalePrice' => $organic->wholesale_price,
            'semiwholesalePrice' => $organic->semiwholesale_price,
            'retailPrice' => $organic->retail_price,
            'updated_by' => $validated['created_by'],
            'add_product_id' => $organic->id,
            'changed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $organic->update(collect($validated)->except('otherRecommendationsPhoto')->toArray());
        $message = 'Organic Amendment updated successfully';

    } else {

        // ---------- CREATE ----------
        $organic = OrganicAmendment::create(collect($validated)->except('otherRecommendationsPhoto')->toArray());

        Notification::create([
            'title'   => 'New Organic Amendment Added',
            'message' => "Organic Amendment {$organic->trade_name} has been added.",
            'is_read' => 0,
        ]);

        $message = 'Organic Amendment created successfully';

        \DB::table('price_histories')->insert([
            'product_id' => $organic->product_id,
            'supplier_id' => $organic->supplier_id,
            'wholesalePrice' => $organic->wholesale_price,
            'semiwholesalePrice' => $organic->semiwholesale_price,
            'retailPrice' => $organic->retail_price,
            'updated_by' => $validated['created_by'],
            'add_product_id' => $organic->id,
            'changed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // ---------- IMAGE UPLOAD ----------
    if ($request->hasFile('otherRecommendationsPhoto')) {
        // Delete old image if exists
        if ($organic->otherRecommendationsPhoto && file_exists(public_path($organic->otherRecommendationsPhoto))) {
            unlink(public_path($organic->otherRecommendationsPhoto));
        }

        $img = $request->file('otherRecommendationsPhoto');
        $folder = public_path('uploads/organic_amendments');
        if (!file_exists($folder)) mkdir($folder, 0755, true);

        $imgName = 'organic_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
        $img->move($folder, $imgName);

        $organic->otherRecommendationsPhoto = 'uploads/organic_amendments/' . $imgName;
        $organic->save();
    }

    // ---------- QR GENERATE ----------
    include_once(public_path('phpqrcode/qrlib.php'));
    $qrFolder = public_path('qrcodes');
    if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

    $qrFileName = 'organic_' . $organic->id . '.png';
    $fullPath = $qrFolder . '/' . $qrFileName;
    $url = url('/organic-amendment/' . $organic->id);

    \QRcode::png($url, $fullPath, 'L', 4, 2);

    $organic->qr_code_path = 'qrcodes/' . $qrFileName;
    $organic->save();

    return response()->json([
        'status' => true,
        'message' => $message,
        'data' => $organic
    ]);
}






// live code h ye
private function storeSyntheticPesticide(Request $request)   
{
    $validated = $request->validate([
        'id' => 'nullable|integer',
        'trade_name' => 'required|string|max:255',
            'localProductName' => 'nullable|string|max:255', // ✅ ADD THIS
        'active_ingredient' => 'nullable|string|max:255',
        'other_active_ingredient' => 'nullable|string|max:255',
        'formulation' => 'nullable|string|max:255',
        'registration_number' => 'required|string|max:255',
        'function' => 'nullable|string|max:255',
        'other_function' => 'nullable|string|max:255',
        'toxicological_class_number' => 'nullable|string|max:255',
        'approval_number' => 'required|string|max:255',
        'wholesale_price' => 'nullable|numeric',
        'semiwholesale_price' => 'nullable|numeric',
        'retail_price' => 'nullable|numeric',
        'product_id' => 'nullable|integer',
        'supplier_id' => 'nullable|integer',
        'agent_id' => 'nullable|integer',
        'status_id' => 'nullable|integer',
        'language_id' => 'nullable|integer',
        'created_by' => 'nullable|integer',
        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // ---------- DEFAULT VALUES ----------
    $validated['language_id'] = $validated['language_id'] ?? 1;
    $validated['form_type'] = 'synthetic_pesticide';
    $validated['created_by'] = $validated['created_by'] ?? (Auth::id() ?? 1);
    $validated['product_id'] = $validated['product_id'] ?? null;
    $validated['agent_id'] = $validated['agent_id'] ?? 1;
    $userId = $validated['created_by'];

    // ---------- STATUS ----------
    if ($request->filled('supplier_id')) {
        $validated['status_id'] = 1;
    } elseif ($request->filled('agent_id') && !$request->filled('supplier_id')) {
        $validated['status_id'] = 4;
    } else {
        $validated['status_id'] = 1;
    }

    try {
        if (!empty($validated['id'])) {
            // ---------- UPDATE ----------
            $pesticide = SyntheticPesticide::find($validated['id']);
            if (!$pesticide) {
                return response()->json(['error' => 'Synthetic pesticide not found.'], 404);
            }

            // ---------- OLD PRICE HISTORY ----------
            \DB::table('price_histories')->insert([
                'product_id' => $pesticide->product_id,
                'supplier_id' => $pesticide->supplier_id,
                'wholesalePrice' => $pesticide->wholesale_price,
                'semiwholesalePrice' => $pesticide->semiwholesale_price,
                'retailPrice' => $pesticide->retail_price,
                'updated_by' => $userId,
                'add_product_id' => $pesticide->id,
                'changed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $newData = collect($validated)->except(['id', 'otherRecommendationsPhoto'])->toArray();
            $newData['parent_id'] = $pesticide->id; // parent_id for versioning

            $pesticide = SyntheticPesticide::create($newData);

            $message = 'Synthetic Pesticide updated successfully';

        } else {
            // ---------- CREATE ----------
            $pesticide = SyntheticPesticide::create(collect($validated)->except('otherRecommendationsPhoto')->toArray());
            $message = 'Synthetic Pesticide created successfully';

            // ---------- PRICE HISTORY ----------
            \DB::table('price_histories')->insert([
                'product_id' => $pesticide->product_id,
                'supplier_id' => $pesticide->supplier_id,
                'wholesalePrice' => $pesticide->wholesale_price,
                'semiwholesalePrice' => $pesticide->semiwholesale_price,
                'retailPrice' => $pesticide->retail_price,
                'updated_by' => $userId,
                'add_product_id' => $pesticide->id,
                'changed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ---------- NOTIFICATION ----------
            Notification::create([
                'title' => 'New Synthetic Pesticide Added',
                'message' => "Pesticide {$validated['trade_name']} has been added.",
                'is_read' => 0,
            ]);
        }

        // ---------- IMAGE STORE ----------
        if ($request->hasFile('otherRecommendationsPhoto')) {
            $img = $request->file('otherRecommendationsPhoto');
            $folder = public_path('uploads/synthetic_pesticide');
            if (!file_exists($folder)) mkdir($folder, 0755, true);

            if (isset($pesticide->otherRecommendationsPhoto) && file_exists(public_path($pesticide->otherRecommendationsPhoto))) {
                unlink(public_path($pesticide->otherRecommendationsPhoto));
            }

            $imgName = 'pesticide_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move($folder, $imgName);

            $pesticide->otherRecommendationsPhoto = 'uploads/synthetic_pesticide/' . $imgName;
            $pesticide->save();
        }

        // ---------- QR CODE ----------
        include_once(public_path('phpqrcode/qrlib.php'));
        $qrFolder = public_path('qrcodes');
        if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

        $qrFileName = 'pesticide_' . $pesticide->id . '.png';
        $url = url('/synthetic-pesticide/' . $pesticide->id);
        \QRcode::png($url, $qrFolder . '/' . $qrFileName, 'L', 4, 2);

        $pesticide->qr_code_path = 'qrcodes/' . $qrFileName;
        $pesticide->save();

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $pesticide
        ], !empty($validated['id']) ? 200 : 201);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to save Synthetic Pesticide',
            'error' => $e->getMessage()
        ], 500);
    }
}


// live code 
private function storeVeterinaryProduct(Request $request) 
{
    $validated = $request->validate([
        'id' => 'nullable|integer', 
            'localProductName' => 'nullable|string|max:255', // ✅ ADD THIS
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
        'targeted_animals' => 'nullable|string|max:255',
        'waiting_period' => 'nullable|string|max:255',
        'expiry_date' => 'nullable|date',
        'transport_storage_requirements' => 'nullable|string|max:255',
        'wholesale_price' => 'required|numeric',
        'semiwholesale_price' => 'required|numeric',
        'retail_price' => 'required|numeric',
        'product_id' => 'required|integer',
        'supplier_id' => 'nullable|integer',
        'agent_id' => 'nullable|integer',
        'status_id' => 'nullable|integer',
        'language_id' => 'nullable|integer',
        'created_by' => 'nullable|integer',
        'otherRecommendationsPhoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // ✅ updated key
    ]);

    // ---------- DEFAULT VALUES ----------
    $validated['language_id'] = $validated['language_id'] ?? 1;
    $validated['created_by'] = $validated['created_by'] ?? (Auth::id() ?? 1);
    $validated['agent_id'] = $validated['agent_id'] ?? 1;
    $validated['form_type'] = 'veterinary_product';

    // ---------- STATUS ----------
    if ($request->filled('supplier_id')) {
        $validated['status_id'] = 1;
    } elseif ($request->filled('agent_id') && !$request->filled('supplier_id')) {
        $validated['status_id'] = 4;
    } else {
        $validated['status_id'] = 1;
    }

    try {
        if (!empty($validated['id'])) {
            // ---------- UPDATE ----------
            $veterinary = VeterinaryProduct::find($validated['id']);
            if (!$veterinary) {
                return response()->json(['error' => 'Veterinary product not found.'], 404);
            }

            // Store old prices
            \DB::table('price_histories')->insert([
                'product_id' => $veterinary->product_id,
                'supplier_id' => $veterinary->supplier_id,
                'wholesalePrice' => $veterinary->wholesale_price,
                'semiwholesalePrice' => $veterinary->semiwholesale_price,
                'retailPrice' => $veterinary->retail_price,
                'updated_by' => $validated['created_by'],
                'add_product_id' => $veterinary->id,
                'changed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $veterinary->update(collect($validated)->except('otherRecommendationsPhoto')->toArray());
            $message = 'Veterinary product updated successfully';
        } else {
            // ---------- CREATE ----------
            $veterinary = VeterinaryProduct::create(collect($validated)->except('otherRecommendationsPhoto')->toArray());
            $message = 'Veterinary product created successfully';

            // Store initial prices
            \DB::table('price_histories')->insert([
                'product_id' => $veterinary->product_id,
                'supplier_id' => $veterinary->supplier_id,
                'wholesalePrice' => $veterinary->wholesale_price,
                'semiwholesalePrice' => $veterinary->semiwholesale_price,
                'retailPrice' => $veterinary->retail_price,
                'updated_by' => $validated['created_by'],
                'add_product_id' => $veterinary->id,
                'changed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Notification::create([
                'title'   => 'New Veterinary Product Added',
                'message' => "Product {$validated['product_name']} has been added.",
                'is_read' => 0,
            ]);
        }

        // ---------- IMAGE UPLOAD ----------
        if ($request->hasFile('otherRecommendationsPhoto')) {
            $img = $request->file('otherRecommendationsPhoto');
            $folder = public_path('uploads/veterinary_product');
            if (!file_exists($folder)) mkdir($folder, 0755, true);

            // Delete old image if exists
            if ($veterinary->otherRecommendationsPhoto && file_exists(public_path($veterinary->otherRecommendationsPhoto))) {
                unlink(public_path($veterinary->otherRecommendationsPhoto));
            }

            $imgName = 'veterinary_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move($folder, $imgName);

            $veterinary->otherRecommendationsPhoto = 'uploads/veterinary_product/' . $imgName;
            $veterinary->save();
        }

        // ---------- QR CODE ----------
        include_once(public_path('phpqrcode/qrlib.php'));
        $qrFolder = public_path('qrcodes');
        if (!file_exists($qrFolder)) mkdir($qrFolder, 0755, true);

        $qrFileName = 'veterinary_' . $veterinary->id . '.png';
        $url = url('/veterinary-product/' . $veterinary->id);
        \QRcode::png($url, $qrFolder . '/' . $qrFileName, 'L', 4, 2);

        $veterinary->qr_code_path = 'qrcodes/' . $qrFileName;
        $veterinary->save();

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $veterinary
        ], !empty($validated['id']) ? 200 : 201);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to save Veterinary Product',
            'error' => $e->getMessage()
        ], 500);
    }
}




public function getOrganicAmendments(Request $request)
{
    try {
        $id = $request->input('id');
        $supplierId = $request->input('supplier_id');
        $agentId = $request->input('agent_id');

        // ========== UNIVERSAL CLEAN FUNCTION ==========
        $cleanRawMaterial = function ($value) use (&$cleanRawMaterial) {

            if (empty($value)) {
                return [];
            }

            // Already array → clean deeper
            if (is_array($value)) {
                $clean = [];
                foreach ($value as $v) {
                    $clean = array_merge($clean, $cleanRawMaterial($v));
                }
                return array_values(array_unique(array_filter($clean)));
            }

            // Convert object to array
            if (is_object($value)) {
                return $cleanRawMaterial((array)$value);
            }

            // Ensure string
            $value = trim((string)$value);

            // Remove line breaks
            $value = str_replace(["\n", "\r"], "", $value);

            // Try JSON Decode
            $json = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $cleanRawMaterial($json);
            }

            // Clean leftover JSON characters
            $value = str_replace(['[', ']', '"', "'", '\\'], '', $value);

            // If comma separated
            if (strpos($value, ',') !== false) {
                $parts = array_map('trim', explode(',', $value));
                return array_values(array_unique(array_filter($parts)));
            }

            // Single value string
            return [trim($value)];
        };
        // =================================================

        $query = OrganicAmendment::query();

        if ($id) {
            $query->where('id', $id);
        }

        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        if ($agentId) {
            $query->where('agent_id', $agentId);
        }

        $organics = $query->get();

        if ($organics->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'No organic amendment data found.',
                'data' => []
            ], 200);
        }

        // Format raw_material using universal cleaner
        $formattedOrganics = $organics->map(function ($item) use ($cleanRawMaterial) {
            if (isset($item->raw_material)) {
                $item->raw_material = $cleanRawMaterial($item->raw_material);
            }
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'Organic amendment data fetched successfully.',
            'data' => $formattedOrganics
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch organic amendment data.',
            'error' => $e->getMessage()
        ], 500);
    }
}






public function getSyntheticPesticides(Request $request)
{
    try {
        $id = $request->input('id');
        $supplierId = $request->input('supplier_id');
        $agentId = $request->input('agent_id');

        $query = SyntheticPesticide::query();

        if ($id) {
            $query->where('id', $id);
        }

        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        if ($agentId) {
            $query->where('agent_id', $agentId);
        }

        $pesticides = $query->get();

        if ($pesticides->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'No synthetic pesticide data found.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Synthetic pesticide data fetched successfully.',
            'data' => $pesticides
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch synthetic pesticide data.',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function getVeterinaryProducts(Request $request)
{
    try {
        $id = $request->input('id');
        $supplierId = $request->input('supplier_id');
        $agentId = $request->input('agent_id');

        $query = VeterinaryProduct::query();

        if ($id) {
            $query->where('id', $id);
        }

        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        if ($agentId) {
            $query->where('agent_id', $agentId);
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'No veterinary product data found.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Veterinary product data fetched successfully.',
            'data' => $products
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch veterinary product data.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function getInorganicSoilConditioners(Request $request)
{
    try {
        $id = $request->input('id');
        $supplierId = $request->input('supplier_id');
        $agentId = $request->input('agent_id');

        $query = \DB::table('inorganic_soil_conditioners');

        if ($id) {
            $query->where('id', $id);
        }

        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        if ($agentId) {
            $query->where('agent_id', $agentId);
        }

        $conditioners = $query->get();

        if ($conditioners->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'No inorganic soil conditioner data found.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Inorganic soil conditioner data fetched successfully.',
            'data' => $conditioners
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch inorganic soil conditioner data.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function getMineralFertilizers(Request $request)
{
    try {
        $id = $request->input('id');
        $supplierId = $request->input('supplier_id');
        $agentId = $request->input('agent_id');

        $query = MineralFertilizer::query();

        if ($id) {
            $query->where('id', $id);
        }

        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        if ($agentId) {
            $query->where('agent_id', $agentId);
        }

        $fertilizers = $query->get();

        if ($fertilizers->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'No mineral fertilizer data found.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Mineral fertilizer data fetched successfully.',
            'data' => $fertilizers
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch mineral fertilizer data.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function getBioStimulants(Request $request)
{
    try {
        $id = $request->input('id');
        $supplierId = $request->input('supplier_id');
        $agentId = $request->input('agent_id');

        $query = BioStimulant::query();

        if ($id) {
            $query->where('id', $id);
        }

        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        if ($agentId) {
            $query->where('agent_id', $agentId);
        }

        $bioStimulants = $query->get();

        if ($bioStimulants->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'No bio-stimulant data found.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Bio-stimulant data fetched successfully.',
            'data' => $bioStimulants
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch bio-stimulant data.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function getAnimalFeeds(Request $request)
{
    try {
        // Optional filters
        $id = $request->input('id');
        $supplierId = $request->input('supplier_id');
        $agentId = $request->input('agent_id');

        $query = AnimalFeed::query();

        if ($id) {
            $query->where('id', $id);
        }

        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        if ($agentId) {
            $query->where('agent_id', $agentId);
        }

        $animalFeeds = $query->get();

        if ($animalFeeds->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No animal feed data found.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Animal feed data fetched successfully.',
            'data' => $animalFeeds
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch animal feed data.',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function getSeedForms(Request $request, $id = null)
{
    try {
        if ($id) {
            // ✅ Get single seed form by ID
            $seedForm = SeedForm::find($id);

            if (!$seedForm) {
                return response()->json([
                    'status' => false,
                    'message' => 'Seed form not found.',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Seed form fetched successfully.',
                'data' => $seedForm
            ], 200);
        } else {
            // ✅ Get all seed forms
            $seedForms = SeedForm::all();

            if ($seedForms->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No seed form data found.',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => 'Seed forms fetched successfully.',
                'data' => $seedForms
            ], 200);
        }

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch seed form data.',
            'error' => $e->getMessage()
        ], 500);
    }
}
// use App\Models\ProductLike;
public function getAllFormData(Request $request)
{
    try {
        $qrBaseUrl = 'https://fivoflow.com/wclm/public/qrcodes/';

        // Filters
        $countryId = $request->query('country_id');
        $supplierId = $request->query('supplier_id');
        $lat        = $request->query('lat');
        $lng        = $request->query('lng');
        $radius     = $request->query('radius', 10);

        $userId      = $request->query('user_id');       // optional user filter
        $deviceToken = $request->query('device_token'); // optional device filter

        // All tables list
        $tables = [
            8 => \App\Models\SeedForm::class,
            1 => \App\Models\VeterinaryProduct::class,
            3 => \App\Models\SyntheticPesticide::class,
            7 => \App\Models\MineralFertilizer::class,
            6 => \App\Models\OrganicAmendment::class,
            4 => \App\Models\InorganicSoilConditioner::class,
            2 => \App\Models\AnimalFeed::class,
            5 => \App\Models\BioStimulant::class,
        ];

        $data = [];

        // Recursive decode helper
        $recursiveDecode = function ($value) use (&$recursiveDecode) {
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $recursiveDecode($decoded);
                }
                return array_map('trim', explode(',', $value));
            } elseif (is_array($value)) {
                $result = [];
                foreach ($value as $v) {
                    $decoded = $recursiveDecode($v);
                    if (is_array($decoded)) {
                        $result = array_merge($result, $decoded);
                    } else {
                        $result[] = $decoded;
                    }
                }
                return $result;
            }
            return $value;
        };

        foreach ($tables as $key => $model) {
            $query = $model::query()->with('supplier');

            if ($supplierId) {
                $query->where('supplier_id', $supplierId);
            }

            if ($countryId) {
                $query->whereHas('supplier', function ($q) use ($countryId) {
                    $q->where('country_id', $countryId);
                });
            }

            if ($lat && $lng) {
                $query->whereHas('supplier', function ($q) use ($lat, $lng, $radius) {
                    $q->whereRaw(
                        "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?))
                        + sin(radians(?)) * sin(radians(latitude)))) <= ?",
                        [$lat, $lng, $lat, $radius]
                    );
                });
            }

            $data[$key] = $query->get()->map(function ($item) use ($qrBaseUrl, $recursiveDecode, $userId, $deviceToken) {

                // Favorite logic (user/device specific)
                $favorite = \App\Models\ProductLike::where('product_id', $item->product_id ?? null)
                    ->where('product_row_id', $item->id)
                    ->when($userId, function($q) use ($userId) {
                        $q->where('user_id', $userId);
                    })
                    ->when($deviceToken, function($q) use ($deviceToken) {
                        $q->where('device_token', $deviceToken);
                    })
                    ->first();

                // Assign actual like_status from DB, default 0
                $item->like_status = $favorite->like_status ?? 0;

                // QR code
                $item->qr_code_url = !empty($item->qr_code_path)
                    ? $qrBaseUrl . basename($item->qr_code_path)
                    : null;

                // Supplier info
                if ($item->supplier) {
                    $item->supplier_name = $item->supplier->company_name;
                    $item->country_id    = $item->supplier->country_id;
                    $item->latitude      = $item->supplier->latitude ?? null;
                    $item->longitude     = $item->supplier->longitude ?? null;
                }

                // Decode & split JSON fields to flat arrays
                $item->raw_material = !empty($item->raw_material) 
                    ? $recursiveDecode($item->raw_material) 
                    : [];
                $item->seed_id = !empty($item->seed_id) 
                    ? $recursiveDecode($item->seed_id) 
                    : [];
                $item->raw_material_other = !empty($item->raw_material_other) 
                    ? $recursiveDecode($item->raw_material_other) 
                    : [];

                return $item;
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'All form data fetched successfully',
            'data'    => $data
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Failed to fetch data',
            'error'   => $e->getMessage()
        ], 500);
    }
}



public function allFilter(Request $request)
{
    try {
        $qrBaseUrl = 'https://fivoflow.com/wclm/public/qrcodes/';

        // ✅ Request params
        $countryId  = $request->query('country_id');
        $supplierId = $request->query('supplier_id');
        $region     = $request->query('region');
        $priceFrom  = $request->query('price_from');
        $priceTo    = $request->query('price_to');
        $yield      = $request->query('yield');
        $tableId    = $request->query('table_id');

        // ✅ Table mapping
        $tables = [
            8 => ['model' => \App\Models\SeedForm::class, 'tastic' => 'seed_form'],
            1 => ['model' => \App\Models\VeterinaryProduct::class, 'tastic' => 'veterinary'],
            3 => ['model' => \App\Models\SyntheticPesticide::class, 'tastic' => 'pesticide'],
            7 => ['model' => \App\Models\MineralFertilizer::class, 'tastic' => 'fertilizer'],
            4 => ['model' => \App\Models\OrganicAmendment::class, 'tastic' => 'organic'],
            6 => ['model' => \App\Models\InorganicSoilConditioner::class, 'tastic' => 'conditioner'],
            2 => ['model' => \App\Models\AnimalFeed::class, 'tastic' => 'feed'],
            5 => ['model' => \App\Models\BioStimulant::class, 'tastic' => 'bio_stimulant'],
        ];

        if ($tableId && isset($tables[$tableId])) {
            $tables = [$tableId => $tables[$tableId]];
        }

        $data = [];

        foreach ($tables as $key => $info) {
            $model = $info['model'];
            $tasticType = $info['tastic'];

            $instance = new $model;
            $table = $instance->getTable();

            $query = $model::query()
                ->leftJoin('suppliers as s', 's.id', '=', $table . '.supplier_id')
                ->leftJoin('price_histories as ph', 'ph.add_product_id', '=', $table . '.id')
                ->select(
                    $table . '.*',
                    'ph.retailPrice',
                    's.company_name as supplier_name',
                    's.country_id',
                    's.region'
                );

            // ✅ Filters
            if ($supplierId) $query->where($table . '.supplier_id', $supplierId);
            if ($countryId) $query->where('s.country_id', $countryId);
            if ($region) $query->where('s.region', 'LIKE', "%$region%");

            // ✅ Price filter null-safe
            if ($priceFrom) $query->where(function($q) use ($priceFrom) {
                $q->whereNull('ph.retailPrice')->orWhere('ph.retailPrice', '>=', $priceFrom);
            });
            if ($priceTo) $query->where(function($q) use ($priceTo) {
                $q->whereNull('ph.retailPrice')->orWhere('ph.retailPrice', '<=', $priceTo);
            });

            // ✅ Yield filter
            if ($yield) {
                $yieldNumeric = preg_replace('/[^0-9.]/', '', $yield);
                $query->where(function($q) use ($yieldNumeric, $table) {
                    if (\Schema::hasColumn($table, 'yield')) {
                        $q->whereRaw("CAST(SUBSTRING_INDEX($table.yield, ' ', 1) AS DECIMAL) = ?", [$yieldNumeric]);
                    }
                    if (\Schema::hasColumn($table, 'expected_yield')) {
                        $q->orWhereRaw("CAST(SUBSTRING_INDEX($table.expected_yield, ' ', 1) AS DECIMAL) = ?", [$yieldNumeric]);
                    }
                });
            }

            $items = $query->get();

            $data[$key] = $items->map(function($item) use ($qrBaseUrl, $tasticType) {
                $item->tastic_type = $tasticType;
                $item->qr_code_url = !empty($item->qr_code_path) ? $qrBaseUrl . basename($item->qr_code_path) : null;
                return $item;
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Filtered data fetched successfully',
            'data'    => $data
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Failed to fetch data',
            'error'   => $e->getMessage()
        ], 500);
    }
}



public function getFormDataById($id, Request $request)
{
    try {
        $qrBaseUrl = 'https://fivoflow.com/wclm/public/qrcodes/';

        $supplierId = $request->query('supplier_id');
        $search     = $request->query('search'); 
        $export     = $request->query('export'); // ?export=csv

        $tables = [
            8 => \App\Models\SeedForm::class,
            1 => \App\Models\VeterinaryProduct::class,
            3 => \App\Models\SyntheticPesticide::class,
            7 => \App\Models\MineralFertilizer::class,
            4 => \App\Models\OrganicAmendment::class,
            6 => \App\Models\InorganicSoilConditioner::class,
            2 => \App\Models\AnimalFeed::class,
            5 => \App\Models\BioStimulant::class,
        ];

        if (!isset($tables[$id])) {
            return response()->json([
                'status' => false,
                'message' => 'No table mapped for this ID'
            ], 404);
        }

        $model = $tables[$id];
        $tableName = (new $model)->getTable();
        $columns = \Schema::getColumnListing($tableName);

        $query = $model::query();

        if (!empty($supplierId)) {
            $query->where('supplier_id', $supplierId);
        }

        if (!empty($search)) {
            $query->where(function($q) use ($search, $columns) {
                foreach ($columns as $field) {
                    $q->orWhere($field, 'LIKE', "%$search%");
                }
            });
        }

        $items = $query->get()->map(function ($item) use ($qrBaseUrl) {

            // ⭐ FAVORITE CHECK (MATCH ONLY product_id + product_row_id)
            $favorite = \App\Models\ProductLike::where('product_id', $item->product_id ?? null)
                ->where('product_row_id', $item->id)
                ->first();

            $item->like_status = $favorite ? 1 : 0;

            // ⭐ QR Code URL
            $item->qr_code_url = !empty($item->qr_code_path)
                ? $qrBaseUrl . basename($item->qr_code_path)
                : null;

            return $item;
        });

        // ⭐ CSV EXPORT
        if (!empty($export) && $export === 'csv') {

            $fileName = 'form_data_' . $id . '_' . time() . '.csv';
            $localPath = storage_path('app/' . $fileName);

            $output = fopen($localPath, 'w');

            fputcsv($output, array_merge($columns, ['like_status', 'qr_code_url']));

            foreach ($items as $item) {
                $row = [];
                foreach ($columns as $field) {
                    $row[] = $item->$field ?? '';
                }
                $row[] = $item->like_status;
                $row[] = $item->qr_code_url ?? '';
                fputcsv($output, $row);
            }

            fclose($output);

            // ⭐ FTP UPLOAD
            $ftp_server = "173.201.186.254";
            $ftp_user   = "lokesh@fivoflow.com";
            $ftp_pass   = "gbvvr#R_7=S*";
            $ftp_dir    = "/wclm/public/exportfile";

            $conn = ftp_connect($ftp_server);
            $login = ftp_login($conn, $ftp_user, $ftp_pass);
            ftp_pasv($conn, true);
            @ftp_mkdir($conn, $ftp_dir);

            $ftp_path = $ftp_dir . "/" . $fileName;

            ftp_put($conn, $ftp_path, $localPath, FTP_ASCII);

            ftp_close($conn);
            unlink($localPath);

            return response()->json([
                'status'   => true,
                'message'  => 'CSV uploaded successfully',
                'ftp_path' => $ftp_path
            ]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Form data fetched successfully',
            'data'    => $items
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch data',
            'error' => $e->getMessage()
        ], 500);
    }
}



public function getAllFormsBySupplier($supplier_id)
{
    try {
        $qrBaseUrl = 'https://fivoflow.com/wclm/public/qrcodes/';

        $tables = [
            8 => \App\Models\SeedForm::class,
            1 => \App\Models\VeterinaryProduct::class,
            3 => \App\Models\SyntheticPesticide::class,
            7 => \App\Models\MineralFertilizer::class,
            4 => \App\Models\OrganicAmendment::class,
            6 => \App\Models\InorganicSoilConditioner::class,
            2 => \App\Models\AnimalFeed::class,
            5 => \App\Models\BioStimulant::class,
        ];

        $data = [];

        foreach ($tables as $key => $model) {

            $table = (new $model)->getTable();

            if (\Schema::hasColumn($table, 'supplier_id')) {

                $records = $model::where('supplier_id', $supplier_id)
                    ->get()
                    ->map(function ($item) use ($qrBaseUrl) {
                        $item->qr_code_url = !empty($item->qr_code_path)
                            ? $qrBaseUrl . basename($item->qr_code_path)
                            : null;
                        return $item;
                    });

                if ($records->isNotEmpty()) {
                    $data[$key] = $records;
                }
            }
        }

        // ✅ No data found response
        if (empty($data)) {
            return response()->json([
                'status'  => false,
                'message' => "No form data found for supplier_id = {$supplier_id}",
                'data'    => []
            ], 404);
        }

        // ✅ Success response
        return response()->json([
            'status'  => true,
            'message' => "Form data fetched successfully for supplier_id = {$supplier_id}",
            'data'    => $data
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Failed to fetch data',
            'error'   => $e->getMessage()
        ], 500);
    }
}
public function getSupplierForms($supplier_id, Request $request)
{
    try {

        // ========== UNIVERSAL CLEAN FUNCTION ==========
        $cleanRawMaterial = function ($value) use (&$cleanRawMaterial) {

            if (empty($value)) {
                return [];
            }

            // Already array → clean deeper
            if (is_array($value)) {
                $clean = [];
                foreach ($value as $v) {
                    $clean = array_merge($clean, $cleanRawMaterial($v));
                }
                return array_values(array_unique(array_filter($clean)));
            }

            // Convert object to array
            if (is_object($value)) {
                return $cleanRawMaterial((array)$value);
            }

            // Ensure string
            $value = trim((string)$value);

            // Remove line breaks
            $value = str_replace(["\n", "\r"], "", $value);

            // Try JSON Decode
            $json = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $cleanRawMaterial($json);
            }

            // Clean leftover JSON characters
            $value = str_replace(['[', ']', '"', "'", '\\'], '', $value);

            // If comma separated
            if (strpos($value, ',') !== false) {
                $parts = array_map('trim', explode(',', $value));
                return array_values(array_unique(array_filter($parts)));
            }

            // Single value string
            return [trim($value)];
        };
        // =================================================


        // Step 1: Supplier Info
        $supplier = \App\Models\Supplier::find($supplier_id);

        if (!$supplier) {
            return response()->json([
                'status' => false,
                'message' => "Supplier not found with ID {$supplier_id}"
            ], 404);
        }

        $qrBaseUrl = 'https://fivoflow.com/wclm/public/qrcodes/';
        $export = $request->query('export');
        $productId = $request->query('product_id');

        // Step 2: Product table mapping
        $tables = [
            'seeds' => \App\Models\SeedForm::class,
            'veterinary_products' => \App\Models\VeterinaryProduct::class,
            'synthetic_pesticides' => \App\Models\SyntheticPesticide::class,
            'mineral_fertilizers' => \App\Models\MineralFertilizer::class,
            'organic_amendments' => \App\Models\OrganicAmendment::class,
            'inorganic_soil_conditioners' => \App\Models\InorganicSoilConditioner::class,
            'animal_feeds' => \App\Models\AnimalFeed::class,
            'biostimulants' => \App\Models\BioStimulant::class,
        ];

        $forms = [];

        // Step 3: Fetch and clean records
        foreach ($tables as $key => $model) {
            $table = (new $model)->getTable();

            if (\Schema::hasColumn($table, 'supplier_id')) {

                $query = $model::where('supplier_id', $supplier_id);

                if (!empty($productId) && \Schema::hasColumn($table, 'product_id')) {
                    $query->where('product_id', $productId);
                }

                $records = $query->get()->map(function ($item) use ($qrBaseUrl, $cleanRawMaterial) {

                    // QR Code URL
                    $item->qr_code_url = !empty($item->qr_code_path)
                        ? $qrBaseUrl . basename($item->qr_code_path)
                        : null;

                    // CLEAN RAW MATERIAL
                    if (isset($item->raw_material)) {
                        $item->raw_material = $cleanRawMaterial($item->raw_material);
                    }

                    return $item;
                });

                $forms[$key] = $records;
            }
        }

        // Step 5: JSON Response
        return response()->json([
            'status' => true,
            'message' => "Forms fetched successfully",
            'supplier' => $supplier,
            'filters' => [
                'supplier_id' => $supplier_id,
                'product_id' => $productId,
            ],
            'forms' => $forms
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch data',
            'error' => $e->getMessage()
        ], 500);
    }
}




public function getAllFormsByAgent($agent_id)
{
    try {
        $qrBaseUrl = 'https://fivoflow.com/wclm/public/qrcodes/';

        $tables = [
            8 => \App\Models\SeedForm::class,
            1 => \App\Models\VeterinaryProduct::class,
            3 => \App\Models\SyntheticPesticide::class,
            7 => \App\Models\MineralFertilizer::class,
            4 => \App\Models\OrganicAmendment::class,
            6 => \App\Models\InorganicSoilConditioner::class,
            2 => \App\Models\AnimalFeed::class,
            5 => \App\Models\BioStimulant::class,
        ];

        $data = [];

        foreach ($tables as $key => $model) {
            if (\Schema::hasColumn((new $model)->getTable(), 'agent_id')) {
                $records = $model::where('agent_id', $agent_id)->get()->map(function ($item) use ($qrBaseUrl) {
                    $item->qr_code_url = !empty($item->qr_code_path)
                        ? $qrBaseUrl . basename($item->qr_code_path)
                        : null;
                    return $item;
                });

                if ($records->isNotEmpty()) {
                    $data[$key] = $records;
                }
            }
        }

        // ✅ MAIN FIX HERE
        if (empty($data)) {
            $data = (object) []; // force {}
        }

        return response()->json([
            'status'  => true,
            'message' => "Form data fetched successfully for agent_id = {$agent_id}",
            'data'    => $data
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Failed to fetch data',
            'error'   => $e->getMessage()
        ], 500);
    }
}


public function searchAllForms(Request $request)
{
    try {
        $search = $request->query('search');
        $qrBaseUrl = 'https://fivoflow.com/wclm/public/qrcodes/';

        if (empty($search)) {
            return response()->json([
                'status' => false,
                'message' => 'Search keyword required'
            ], 400);
        }

        // ✅ All models list
        $tables = [
            8 => \App\Models\SeedForm::class,
            1 => \App\Models\VeterinaryProduct::class,
            3 => \App\Models\SyntheticPesticide::class,
            7 => \App\Models\MineralFertilizer::class,
            4 => \App\Models\OrganicAmendment::class,
            6 => \App\Models\InorganicSoilConditioner::class,
            2 => \App\Models\AnimalFeed::class,
            5 => \App\Models\BioStimulant::class,
        ];

        // ✅ Search fields for each model
        $searchFields = [
            2 => ['Typeoffeed'],                                // animal_feeds ✅ confirmed
            5 => ['biostimulant_product', 'action_mode'],       // bio_stimulants
            6 => ['trade_name', 'raw_material'],                // inorganic_soil_conditioners
            7 => ['trade_name', 'fertilizer_type'],             // mineral_fertilizers
            4 => ['trade_name', 'bio_label'],                   // organic_amendments
            8 => ['cropName', 'breederName'],                   // seed_forms
            3 => ['trade_name', 'other_function'],              // synthetic_pesticides
            1 => ['product_name', 'manufacturing_lab'],         // veterinary_products
        ];

        $finalResult = [];

        foreach ($tables as $id => $model) {
            $query = $model::query();

            if (isset($searchFields[$id])) {
                $fields = $searchFields[$id];

                $query->where(function($q) use ($search, $fields, $model) {
                    foreach ($fields as $field) {
                        if (\Schema::hasColumn((new $model)->getTable(), $field)) {
                            $q->orWhere($field, 'LIKE', "%$search%");
                        }
                    }
                });

                $records = $query->get()->map(function ($item) use ($qrBaseUrl, $id) {
                    $item->form_id = $id;
                    $item->qr_code_url = !empty($item->qr_code_path)
                        ? $qrBaseUrl . basename($item->qr_code_path)
                        : null;
                    return $item;
                });

                if ($records->count() > 0) {
                    $finalResult = array_merge($finalResult, $records->toArray());
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Search results fetched successfully',
            'data' => $finalResult
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to search data',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function updateProductStatus(Request $request)
{
    // Validate input
    $request->validate([
        'table_id'    => 'required|integer',
        'product_id'  => 'required|integer',
        'agent_id'    => 'required|integer',
        'supplier_id' => 'nullable|integer',
        'status_id'   => 'required|integer'
    ]);

    // Table mapping
    $tables = [
        8 => \App\Models\SeedForm::class,
        1 => \App\Models\VeterinaryProduct::class,
        3 => \App\Models\SyntheticPesticide::class,
        7 => \App\Models\MineralFertilizer::class,
        4 => \App\Models\OrganicAmendment::class,
        6 => \App\Models\InorganicSoilConditioner::class,
        2 => \App\Models\AnimalFeed::class,
        5 => \App\Models\BioStimulant::class,
    ];

    if (!array_key_exists($request->table_id, $tables)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid table_id'
        ], 400);
    }

    $model = $tables[$request->table_id];

    // Product find with ONLY product_id + agent_id
    $product = $model::where('id', $request->product_id)
                     ->where('agent_id', $request->agent_id)
                     ->first();

    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found for this agent'
        ], 404);
    }

    // Update status and supplier_id if provided
    $product->status_id = $request->status_id;
    
    // supplier_id update only if provided
    if ($request->filled('supplier_id')) {
        $product->supplier_id = $request->supplier_id;
    }

    $product->save();

    return response()->json([
        'status' => true,
        'message' => 'Product status updated successfully',
        'product' => $product
    ]);
}





public function getSuppliersByProducttt(Request $request)
{
    try {

        // -------------------------------
        // INPUTS
        // -------------------------------
        $productId    = $request->query('product_id');      // eg: 8
        $productTitle = $request->query('product_title');   // eg: Maize

        // ✅ REAL OFFSET PAGINATION
        $limit  = (int) $request->query('limit', 7);
        $offset = max(0, (int) $request->query('offset', 0));

        // -------------------------------
        // PRODUCT TABLE MAPPING
        // -------------------------------
        $tables = [
            1 => [\App\Models\VeterinaryProduct::class, ['product_name', 'title']],
            2 => [\App\Models\AnimalFeed::class, ['title', 'Typeoffeed']],
            3 => [\App\Models\SyntheticPesticide::class, ['trade_name']],
            4 => [\App\Models\OrganicAmendment::class, ['trade_name']],
            5 => [\App\Models\BioStimulant::class, ['trade_name']],
            6 => [\App\Models\InorganicSoilConditioner::class, ['trade_name']],
            7 => [\App\Models\MineralFertilizer::class, ['title', 'trade_name']],
            8 => [\App\Models\SeedForm::class, ['cropName', 'title']],
        ];

        $allRecords  = [];
        $supplierIds = [];
        $qrBaseUrl   = 'https://fivoflow.com/wclm/public/qrcodes/';

        // -------------------------------
        // FETCH DATA FROM ALL TABLES
        // -------------------------------
        foreach ($tables as $key => $tableInfo) {

            // product_id filter
            if ($productId && (int)$productId !== (int)$key) {
                continue;
            }

            [$model, $searchColumns] = $tableInfo;

            $query = $model::query();

            // product_title filter
            if (!empty($productTitle)) {
                $query->where(function ($q) use ($searchColumns, $productTitle) {
                    foreach ($searchColumns as $col) {
                        $q->orWhere($col, 'LIKE', "%{$productTitle}%");
                    }
                });
            }

            // ✅ STABLE ORDER
            $records = $query->orderBy('id', 'asc')->get();

            foreach ($records as $record) {

                if (!empty($record->supplier_id)) {
                    $supplierIds[] = $record->supplier_id;
                }

                // extra fields
                $record->product_type = $key;

                $record->qr_code_url = !empty($record->qr_code_path)
                    ? $qrBaseUrl . basename($record->qr_code_path)
                    : null;

                $allRecords[] = $record;
            }
        }

        // -------------------------------
        // SORT MERGED RECORDS
        // -------------------------------
        usort($allRecords, function ($a, $b) {
            return $a->id <=> $b->id;
        });

        // -------------------------------
        // PAGINATION AFTER MERGE
        // -------------------------------
        $totalRecords   = count($allRecords);
        $paginatedForms = array_slice($allRecords, $offset, $limit);

        // -------------------------------
        // SUPPLIER DATA
        // -------------------------------
        $supplierIds = array_unique($supplierIds);

        $suppliers = !empty($supplierIds)
            ? \App\Models\Supplier::whereIn('id', $supplierIds)->get()
            : [];

        // -------------------------------
        // RESPONSE
        // -------------------------------
        return response()->json([
            'status' => true,
            'message' => 'Suppliers fetched successfully',
            'filters' => [
                'product_id'    => $productId,
                'product_title' => $productTitle,
                'limit'         => $limit,
                'offset'        => $offset,
            ],
            'pagination' => [
                'total_records' => $totalRecords,
                'limit'         => $limit,
                'current_offset'=> $offset,
                'next_offset'   => ($offset + $limit < $totalRecords) ? $offset + $limit : null,
            ],
            'forms'     => $paginatedForms,
            'suppliers' => $suppliers,
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch suppliers',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function getSuppliersByProducast(Request $request)
{
    try {

        // -------------------------------
        // INPUTS
        // -------------------------------
        $productId    = $request->query('product_id');
        $productTitle = $request->query('product_title');

        // ✅ offset = record number (1-based)
        $offset = max(1, (int) $request->query('offset', 1));
        $limit  = 1; // 👈 ALWAYS 1 RECORD

        // convert to array index
        $start = $offset - 1;

        // -------------------------------
        // PRODUCT TABLE MAPPING
        // -------------------------------
        $tables = [
            1 => [\App\Models\VeterinaryProduct::class, ['product_name', 'title']],
            2 => [\App\Models\AnimalFeed::class, ['title', 'Typeoffeed']],
            3 => [\App\Models\SyntheticPesticide::class, ['trade_name']],
            4 => [\App\Models\OrganicAmendment::class, ['trade_name']],
            5 => [\App\Models\BioStimulant::class, ['trade_name']],
            6 => [\App\Models\InorganicSoilConditioner::class, ['trade_name']],
            7 => [\App\Models\MineralFertilizer::class, ['title', 'trade_name']],
            8 => [\App\Models\SeedForm::class, ['cropName', 'title']],
        ];

        $allRecords  = [];
        $supplierIds = [];
        $qrBaseUrl   = 'https://fivoflow.com/wclm/public/qrcodes/';

        // -------------------------------
        // FETCH DATA
        // -------------------------------
        foreach ($tables as $key => $tableInfo) {

            if ($productId && (int)$productId !== (int)$key) {
                continue;
            }

            [$model, $searchColumns] = $tableInfo;
            $query = $model::query();

            if (!empty($productTitle)) {
                $query->where(function ($q) use ($searchColumns, $productTitle) {
                    foreach ($searchColumns as $col) {
                        $q->orWhere($col, 'LIKE', "%{$productTitle}%");
                    }
                });
            }

            $records = $query->orderBy('id', 'asc')->get();

            foreach ($records as $record) {

                if (!empty($record->supplier_id)) {
                    $supplierIds[] = $record->supplier_id;
                }

                $record->product_type = $key;
                $record->qr_code_url = !empty($record->qr_code_path)
                    ? $qrBaseUrl . basename($record->qr_code_path)
                    : null;

                $allRecords[] = $record;
            }
        }

        // -------------------------------
        // SORT
        // -------------------------------
        usort($allRecords, fn($a, $b) => $a->id <=> $b->id);

        // -------------------------------
        // SINGLE RECORD PAGINATION
        // -------------------------------
        $totalRecords = count($allRecords);
        $record       = $allRecords[$start] ?? null;

        // -------------------------------
        // SUPPLIERS
        // -------------------------------
        $suppliers = [];
        if ($record && !empty($record->supplier_id)) {
            $suppliers = \App\Models\Supplier::where('id', $record->supplier_id)->get();
        }

        // -------------------------------
        // RESPONSE
        // -------------------------------
        return response()->json([
            'status' => true,
            'message' => 'Supplier fetched successfully',
            'pagination' => [
                'total_records' => $totalRecords,
                'current_offset'=> $offset,
                'next_offset'   => ($offset < $totalRecords) ? $offset + 1 : null,
                'prev_offset'   => ($offset > 1) ? $offset - 1 : null,
            ],
            'form'     => $record,
            'suppliers'=> $suppliers,
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch data',
            'error' => $e->getMessage(),
        ], 500);
    }
}



public function getSuppliersByProduct(Request $request)
{
    try {

        // -------------------------------
        // INPUTS
        // -------------------------------
        $productId    = $request->query('product_id');
        $productTitle = $request->query('product_title');

        // ✅ OFFSET = PAGE NUMBER (0 BASED)
        $limit  = (int) $request->query('limit', 7);
        $offset = max(0, (int) $request->query('offset', 0));

        // 🔑 KEY LINE (NO DUPLICATE DATA)
        $start = $offset * $limit;

        // -------------------------------
        // PRODUCT TABLE MAPPING
        // -------------------------------
        $tables = [
            1 => [\App\Models\VeterinaryProduct::class, ['product_name', 'title']],
            2 => [\App\Models\AnimalFeed::class, ['title', 'Typeoffeed']],
            3 => [\App\Models\SyntheticPesticide::class, ['trade_name']],
            4 => [\App\Models\OrganicAmendment::class, ['trade_name']],
            5 => [\App\Models\BioStimulant::class, ['trade_name']],
            6 => [\App\Models\InorganicSoilConditioner::class, ['trade_name']],
            7 => [\App\Models\MineralFertilizer::class, ['title', 'trade_name']],
            8 => [\App\Models\SeedForm::class, ['cropName', 'title']],
        ];

        $allRecords = [];
        $qrBaseUrl  = 'https://fivoflow.com/wclm/public/qrcodes/';

        // -------------------------------
        // FETCH & MERGE DATA
        // -------------------------------
        foreach ($tables as $key => $tableInfo) {

            if ($productId && (int)$productId !== (int)$key) {
                continue;
            }

            [$model, $searchColumns] = $tableInfo;
            $query = $model::query();

            if (!empty($productTitle)) {
                $query->where(function ($q) use ($searchColumns, $productTitle) {
                    foreach ($searchColumns as $col) {
                        $q->orWhere($col, 'LIKE', "%{$productTitle}%");
                    }
                });
            }

            // ✅ SAME ORDER EVERY TIME
            $records = $query->orderBy('id', 'asc')->get();

            foreach ($records as $record) {

                $record->product_type = $key;

                $record->qr_code_url = !empty($record->qr_code_path)
                    ? $qrBaseUrl . basename($record->qr_code_path)
                    : null;

                $allRecords[] = $record;
            }
        }

        // -------------------------------
        // GLOBAL SORT
        // -------------------------------
        usort($allRecords, fn ($a, $b) => $a->id <=> $b->id);

        // -------------------------------
        // PAGINATION
        // -------------------------------
        $totalRecords = count($allRecords);
        $forms = array_slice($allRecords, $start, $limit);

        // -------------------------------
        // SUPPLIERS (ONLY IF PRODUCTS EXIST)
        // -------------------------------
        $suppliers = [];

        if (!empty($forms)) {

            $supplierIds = [];

            foreach ($forms as $form) {
                if (!empty($form->supplier_id)) {
                    $supplierIds[] = $form->supplier_id;
                }
            }

            $supplierIds = array_unique($supplierIds);

            if (!empty($supplierIds)) {
                $suppliers = \App\Models\Supplier::whereIn('id', $supplierIds)->get();
            }
        }

        // -------------------------------
        // RESPONSE
        // -------------------------------
        return response()->json([
            'status' => true,
            'message' => 'Suppliers fetched successfully',
            'pagination' => [
                'limit'         => $limit,
                'offset'        => $offset,
                'current_page'  => $offset + 1,
                'total_records' => $totalRecords,
                'total_pages'   => ceil($totalRecords / $limit),
                'next_offset'   => ($start + $limit < $totalRecords) ? $offset + 1 : null,
            ],
            'forms'     => $forms,
            'suppliers' => $suppliers, // ✅ empty if no product data
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch suppliers',
            'error'   => $e->getMessage(),
        ], 500);
    }
}


public function getProductSuggestions(Request $request)
{
    $search = trim($request->search);

    if (!$search) {
        return response()->json([]);
    }

    // ✅ PRODUCTS + JOIN ALL TABLES
    $products = DB::table('products')
        ->leftJoin('animal_feeds', 'products.id', '=', 'animal_feeds.product_id')
        ->leftJoin('bio_stimulants', 'products.id', '=', 'bio_stimulants.product_id')
        ->leftJoin('mineral_fertilizers', 'products.id', '=', 'mineral_fertilizers.product_id')
        ->leftJoin('inorganic_soil_conditioners', 'products.id', '=', 'inorganic_soil_conditioners.product_id')
        ->leftJoin('organic_amendments', 'products.id', '=', 'organic_amendments.product_id')
        ->leftJoin('synthetic_pesticides', 'products.id', '=', 'synthetic_pesticides.product_id')
        ->leftJoin('veterinary_products', 'products.id', '=', 'veterinary_products.product_id')
        // ✅ JOIN suppliers table
        ->leftJoin('suppliers', function($join) {
            $join->on('suppliers.id', '=', DB::raw('COALESCE(
                animal_feeds.supplier_id,
                bio_stimulants.supplier_id,
                mineral_fertilizers.supplier_id,
                inorganic_soil_conditioners.supplier_id,
                organic_amendments.supplier_id,
                synthetic_pesticides.supplier_id,
                veterinary_products.supplier_id
            )'));
        })
        ->where('products.name', 'like', '%' . $search . '%')
        ->select(
            'products.id as product_id',
            'products.name as product_name',
            'suppliers.id as supplier_id',
            'suppliers.company_name',
            'suppliers.manager_name',
            'suppliers.name',
            'suppliers.position',
            'suppliers.image',
            'suppliers.city',
            'suppliers.region',
            'suppliers.address',
            'suppliers.phone',
            'suppliers.mobile',
            'suppliers.email'
        )
        ->get();

    // ✅ OTHER TABLES DIRECT SEARCH (optional)
    $animalFeeds = DB::table('animal_feeds')
        ->leftJoin('suppliers', 'animal_feeds.supplier_id', '=', 'suppliers.id')
        ->where('afrm', 'like', '%' . $search . '%')
        ->select(
            DB::raw('NULL as product_id'),
            DB::raw('afrm as product_name'),
            'suppliers.id as supplier_id',
            'suppliers.company_name',
            'suppliers.manager_name',
            'suppliers.name',
            'suppliers.position',
            'suppliers.image',
            'suppliers.city',
            'suppliers.region',
            'suppliers.address',
            'suppliers.phone',
            'suppliers.mobile',
            'suppliers.email'
        )
        ->get();

    $bio = DB::table('bio_stimulants')
        ->leftJoin('suppliers', 'bio_stimulants.supplier_id', '=', 'suppliers.id')
        ->where('trade_name', 'like', '%' . $search . '%')
        ->select(
            'bio_stimulants.id as product_id',
            DB::raw('trade_name as product_name'),
            'suppliers.id as supplier_id',
            'suppliers.company_name',
            'suppliers.manager_name',
            'suppliers.name',
            'suppliers.position',
            'suppliers.image',
            'suppliers.city',
            'suppliers.region',
            'suppliers.address',
            'suppliers.phone',
            'suppliers.mobile',
            'suppliers.email'
        )
        ->get();

    $mineral = DB::table('mineral_fertilizers')
        ->leftJoin('suppliers', 'mineral_fertilizers.supplier_id', '=', 'suppliers.id')
        ->where('trade_name', 'like', '%' . $search . '%')
        ->select(
            'mineral_fertilizers.id as product_id',
            DB::raw('trade_name as product_name'),
            'suppliers.id as supplier_id',
            'suppliers.company_name',
            'suppliers.manager_name',
            'suppliers.name',
            'suppliers.position',
            'suppliers.image',
            'suppliers.city',
            'suppliers.region',
            'suppliers.address',
            'suppliers.phone',
            'suppliers.mobile',
            'suppliers.email'
        )
        ->get();

    // ✅ MERGE ALL RESULTS
    $results = collect()
        ->merge($products)
        ->merge($animalFeeds)
        ->merge($bio)
        ->merge($mineral)
        ->filter(function ($item) {
            return !empty($item->product_name);
        })
        ->unique(function ($item) {
            return $item->product_name . '-' . $item->supplier_id;
        })
        ->values();

    return response()->json($results);
}

public function search(Request $request)
{
    $search = trim($request->search);

    if (!$search) {
        return response()->json([
            'status' => false,
            'message' => 'Search keyword required'
        ]);
    }

    // ================== ANIMAL FEEDS ==================
    $animalFeeds = DB::table('animal_feeds')
        ->join('suppliers', 'animal_feeds.supplier_id', '=', 'suppliers.id')
        ->where('animal_feeds.title', 'LIKE', "%$search%")
        ->select(
            'animal_feeds.id',
            'animal_feeds.title as product_name',
            'animal_feeds.afretailPrice as price',
            'suppliers.company_name',
            'suppliers.name as supplier_name',
            DB::raw("'animal_feed' as type")
        );

    // ================== BIO STIMULANTS ==================
    $bio = DB::table('bio_stimulants')
        ->join('suppliers', 'bio_stimulants.supplier_id', '=', 'suppliers.id')
        ->where('bio_stimulants.trade_name', 'LIKE', "%$search%")
        ->select(
            'bio_stimulants.id',
            'bio_stimulants.trade_name as product_name',
            'bio_stimulants.retail_price as price',
            'suppliers.company_name',
            'suppliers.name as supplier_name',
            DB::raw("'bio_stimulant' as type")
        );

    // ================== FERTILIZERS ==================
    $fertilizers = DB::table('mineral_fertilizers')
        ->join('suppliers', 'mineral_fertilizers.supplier_id', '=', 'suppliers.id')
        ->where('mineral_fertilizers.trade_name', 'LIKE', "%$search%")
        ->select(
            'mineral_fertilizers.id',
            'mineral_fertilizers.trade_name as product_name',
            'mineral_fertilizers.fertilizer_retail_price as price',
            'suppliers.company_name',
            'suppliers.name as supplier_name',
            DB::raw("'fertilizer' as type")
        );

    // ================== UNION ==================
    $results = $animalFeeds
        ->unionAll($bio)
        ->unionAll($fertilizers)
        ->get();

    return response()->json([
        'status' => true,
        'data' => $results
    ]);
}

}




