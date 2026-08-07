<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InorganicSoilConditioner;
use App\Models\InorganicSoilConditionerTranslation;
use App\Models\Seed;
use App\Models\Language;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

class InorganicSoilConditionerApiController extends Controller
{
    // List all records
    public function index()
    {
        $conditioners = InorganicSoilConditioner::with(['seed', 'translations.language'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $conditioners
        ], 200);
    }

    // Show a single record
    public function show($id)
    {
        $conditioner = InorganicSoilConditioner::with(['seed', 'translations.language'])->find($id);

        if (!$conditioner) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conditioner not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $conditioner
        ], 200);
    }

    // Store a new record
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'form_type' => 'required|string|max:50',
            'seed_id' => 'nullable|exists:seed,id',
            'conditioner_type' => 'required|string|max:255',
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
        ]);

        $validated['created_by'] = $request->user()->id ?? null;

        if (!$validated['created_by']) {
            return response()->json([
                'status' => 'error',
                'message' => 'You must be logged in to submit.'
            ], 401);
        }

        // Save main record
        $conditioner = InorganicSoilConditioner::create($validated);

        // Get all languages
        $languages = Language::all();
        $fieldsToTranslate = ['conditioner_type', 'physical_form', 'trade_name', 'raw_material', 'other', 'function'];

        foreach ($languages as $lang) {
            if (empty($lang->lang_code)) continue;

            $tr = new GoogleTranslate($lang->lang_code);

            $translationData = [
                'inorganic_soil_conditioner_id' => $conditioner->id,
                'language_id' => $lang->id,
                'created_by' => $conditioner->created_by,
                'supplier_id' => $conditioner->supplier_id,
                'agent_id' => $conditioner->agent_id,
            ];

            foreach ($fieldsToTranslate as $field) {
                if (!empty($conditioner->$field)) {
                    try {
                        $translationData[$field] = $tr->translate($conditioner->$field);
                    } catch (\Exception $e) {
                        $translationData[$field] = $conditioner->$field;
                    }
                } else {
                    $translationData[$field] = null;
                }
            }

            $translationData['wholesale_price'] = $conditioner->wholesale_price;
            $translationData['semiwholesale_price'] = $conditioner->semiwholesale_price;
            $translationData['retail_price'] = $conditioner->retail_price;

            InorganicSoilConditionerTranslation::create($translationData);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Inorganic Soil Conditioner saved and translated successfully!',
            'data' => $conditioner
        ], 201);
    }
}
