<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeedForm;
use App\Models\Language;
use App\Models\SeedFormTranslation;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Exception;

class SeedFormApiController extends Controller
{
    // ✅ Store
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'form_type' => 'string|max:50',
                'seed_id' => 'required|exists:seed,id',
                'language_id' => 'integer', // optional
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
                'InherentNutritionalValue' => 'nullable|array',
                'other' => 'nullable|string|max:255',
                'yield' => 'nullable|string|max:255',
                'otherRecommendations' => 'nullable|string|max:255',
                'otherRecommendationsPhoto' => 'nullable',
                'wholesalePrice' => 'required|numeric',
                'semiwholesalePrice' => 'required|numeric',
                'retailPrice' => 'required|numeric',
                'supplier_id' => 'nullable|exists:suppliers,id',
                'agent_id' => 'nullable|exists:agents,id',
            ]);

            // Implode array if exists
            if ($request->has('InherentNutritionalValue')) {
                $validated['InherentNutritionalValue'] = implode(',', $request->InherentNutritionalValue);
            }

            // Set default language_id to 1 if not provided
            $validated['language_id'] = $request->language_id ?? 1;

            // Handle photo upload
            if ($request->has('otherRecommendationsPhoto') && $request->otherRecommendationsPhoto) {
                $photo = $request->otherRecommendationsPhoto;

                if (preg_match('/^data:image\/(\w+);base64,/', $photo, $type)) {
                    $photo = substr($photo, strpos($photo, ',') + 1);
                    $type = strtolower($type[1]);
                    $photo = base64_decode($photo);
                    if ($photo === false) throw new Exception('Base64 decode failed');

                    $filename = time() . '.' . $type;
                    if (!file_exists(public_path('uploads/seeds'))) {
                        mkdir(public_path('uploads/seeds'), 0777, true);
                    }
                    file_put_contents(public_path('uploads/seeds/' . $filename), $photo);
                    $validated['otherRecommendationsPhoto'] = $filename;
                } else if ($request->hasFile('otherRecommendationsPhoto')) {
                    $file = $request->file('otherRecommendationsPhoto');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    if (!file_exists(public_path('uploads/seeds'))) {
                        mkdir(public_path('uploads/seeds'), 0777, true);
                    }
                    $file->move(public_path('uploads/seeds'), $filename);
                    $validated['otherRecommendationsPhoto'] = $filename;
                }
            }

            $validated['created_by'] = Auth::id() ?? 1;
            $seedForm = SeedForm::create($validated);

            // Generate translations for all languages
            $languages = Language::all();
            $tr = new GoogleTranslate();

            foreach ($languages as $lang) {
                $tr->setTarget($lang->lang_code);
                SeedFormTranslation::create([
                    'seed_form_id' => $seedForm->id,
                    'language_id' => $lang->id,
                    'title' => $request->title ? $tr->translate($request->title) : null,
                    'cropName' => $tr->translate($request->cropName),
                    'verityName' => $tr->translate($request->verityName),
                    'breederName' => $tr->translate($request->breederName ?? ''),
                    'countryOrigin' => $tr->translate($request->countryOrigin ?? ''),
                    'registrationNumber' => $tr->translate($request->registrationNumber),
                    'varietyType' => $tr->translate($request->varietyType ?? ''),
                    'seedCategory' => $tr->translate($request->seedCategory ?? ''),
                    'precocity' => $tr->translate($request->precocity ?? ''),
                    'fruitColor' => $tr->translate($request->fruitColor ?? ''),
                    'fruitShape' => $tr->translate($request->fruitShape ?? ''),
                    'leafLength' => $tr->translate($request->leafLength ?? ''),
                    'leafColor' => $tr->translate($request->leafColor ?? ''),
                    'plantHeight' => $tr->translate($request->plantHeight ?? ''),
                    'plantHabit' => $tr->translate($request->plantHabit ?? ''),
                    'bioticResistance' => $tr->translate($request->bioticResistance ?? ''),
                    'abioticResistance' => $tr->translate($request->abioticResistance ?? ''),
                    'InherentNutritionalValue' => $validated['InherentNutritionalValue'] ?? null,
                    'other' => $tr->translate($request->other ?? ''),
                    'yield' => $tr->translate($request->yield ?? ''),
                    'otherRecommendations' => $tr->translate($request->otherRecommendations ?? ''),
                    'supplier_id' => $request->supplier_id,
                    'agent_id' => $request->agent_id,
                    'created_by' => $validated['created_by'],
                ]);
            }

            $seedForm->otherRecommendationsPhoto = $seedForm->otherRecommendationsPhoto 
                ? url('uploads/seeds/'.$seedForm->otherRecommendationsPhoto) 
                : null;

            return response()->json([
                'status' => true,
                'message' => 'Seed form saved successfully with translations!',
                'data' => $seedForm
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to save seed form',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ✅ UPDATE METHOD
    public function update(Request $request, $id)
    {
        try {
            $seedForm = SeedForm::findOrFail($id);

            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'cropName' => 'nullable|string|max:255',
                'verityName' => 'nullable|string|max:255',
                'breederName' => 'nullable|string|max:255',
                'countryOrigin' => 'nullable|string|max:255',
                'registrationNumber' => 'nullable|string|max:255',
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
                'InherentNutritionalValue' => 'nullable|array',
                'other' => 'nullable|string|max:255',
                'yield' => 'nullable|string|max:255',
                'otherRecommendations' => 'nullable|string|max:255',
                'otherRecommendationsPhoto' => 'nullable',
                'wholesalePrice' => 'nullable|numeric',
                'semiwholesalePrice' => 'nullable|numeric',
                'retailPrice' => 'nullable|numeric',
                'language_id' => 'integer', // optional for update
            ]);

            if ($request->has('InherentNutritionalValue')) {
                $validated['InherentNutritionalValue'] = implode(',', $request->InherentNutritionalValue);
            }

            // Default language_id to 1 if not provided
            $validated['language_id'] = $request->language_id ?? ($seedForm->language_id ?? 1);

            // Handle photo upload
            if ($request->has('otherRecommendationsPhoto') && $request->otherRecommendationsPhoto) {
                $photo = $request->otherRecommendationsPhoto;
                if (preg_match('/^data:image\/(\w+);base64,/', $photo, $type)) {
                    $photo = substr($photo, strpos($photo, ',') + 1);
                    $type = strtolower($type[1]);
                    $photo = base64_decode($photo);

                    $filename = time() . '.' . $type;
                    if (!file_exists(public_path('uploads/seeds'))) {
                        mkdir(public_path('uploads/seeds'), 0777, true);
                    }
                    file_put_contents(public_path('uploads/seeds/' . $filename), $photo);
                    $validated['otherRecommendationsPhoto'] = $filename;
                } else if ($request->hasFile('otherRecommendationsPhoto')) {
                    $file = $request->file('otherRecommendationsPhoto');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/seeds'), $filename);
                    $validated['otherRecommendationsPhoto'] = $filename;
                }
            }

            $seedForm->update($validated);

            // Update translations also
            $translations = SeedFormTranslation::where('seed_form_id', $id)->get();
            $tr = new GoogleTranslate();

            foreach ($translations as $translation) {
                $tr->setTarget($translation->language->lang_code);

                $translation->update([
                    'title' => $request->title ? $tr->translate($request->title) : $translation->title,
                    'cropName' => $request->cropName ? $tr->translate($request->cropName) : $translation->cropName,
                    'verityName' => $request->verityName ? $tr->translate($request->verityName) : $translation->verityName,
                    'otherRecommendations' => $request->otherRecommendations ? $tr->translate($request->otherRecommendations) : $translation->otherRecommendations,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Seed form updated successfully!',
                'data' => $seedForm
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update seed form',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ✅ Get all
    public function index()
    {
        $seedForms = SeedForm::with(['translations'])->get();

        foreach ($seedForms as $form) {
            $form->otherRecommendationsPhoto = $form->otherRecommendationsPhoto 
                ? url('uploads/seeds/'.$form->otherRecommendationsPhoto) 
                : null;
        }

        return response()->json(['status' => true, 'data' => $seedForms]);
    }

    // ✅ Get single
    public function show($id)
    {
        $seedForm = SeedForm::with(['translations'])->find($id);

        if (!$seedForm) {
            return response()->json(['status' => false, 'message' => 'Seed form not found'], 404);
        }

        $seedForm->otherRecommendationsPhoto = $seedForm->otherRecommendationsPhoto 
            ? url('uploads/seeds/'.$seedForm->otherRecommendationsPhoto) 
            : null;

        return response()->json(['status' => true, 'data' => $seedForm]);
    }
}
