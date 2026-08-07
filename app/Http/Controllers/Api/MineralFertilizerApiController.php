<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MineralFertilizer;
use App\Models\MineralFertilizerTranslation;
use Exception;
use Illuminate\Support\Facades\DB;

class MineralFertilizerApiController extends Controller
{
    /**
     * GET: All Mineral Fertilizers
     */
    public function index()
    {
        try {
            $fertilizers = MineralFertilizer::with(['seed:id,name', 'translations', 'language'])->get();

            return response()->json([
                'status' => true,
                'message' => 'Mineral Fertilizers fetched successfully',
                'data' => $fertilizers
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching Mineral Fertilizers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET: Single Mineral Fertilizer by ID
     */
    public function show($id)
    {
        try {
            $fertilizer = MineralFertilizer::with(['seed:id,name', 'translations', 'language'])->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Mineral Fertilizer fetched successfully',
                'data' => $fertilizer
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Mineral Fertilizer not found',
                'error' => $e->getMessage()
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching Mineral Fertilizer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function store(Request $request)
{
    $request->validate([
        'title' => 'nullable|string',
        'seed_id' => 'required|integer',
        'fertilizer_type' => 'required|string',
        'language_id' => 'nullable|integer', 
        'form_type' => 'nullable|string',
        'supplier_id' => 'nullable|integer',
        'agent_id' => 'nullable|integer',
        'created_by' => 'nullable|integer',
        'fertilizer_registration' => 'nullable|string',
        'physical_form' => 'nullable|string',
        'trade_name' => 'nullable|string',
        'application_rate' => 'nullable|string',
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
    ]);

    try {
        DB::beginTransaction();

        $languageId = $request->input('language_id', 1); 
        $title = $request->input('title'); // no default

        // Create main fertilizer
        $fertilizer = MineralFertilizer::create([
            'title' => $title,
            'form_type' => $request->form_type ?? 'mineral_fertilizer',
            'fertilizer_type' => $request->fertilizer_type,
            'fertilizer_registration' => $request->fertilizer_registration ?? '',
            'physical_form' => $request->physical_form ?? '',
            'trade_name' => $request->trade_name ?? '',
            'seed_id' => $request->seed_id,
            'supplier_id' => $request->supplier_id ?? null,
            'agent_id' => $request->agent_id ?? null,
            'created_by' => $request->created_by ?? null,
            'language_id' => $languageId,
            'application_rate' => $request->application_rate ?? '',
            'n' => $request->n ?? 0,
            'p2' => $request->p2 ?? 0,
            'k2' => $request->k2 ?? 0,
            'zn' => $request->zn ?? 0,
            'ca' => $request->ca ?? 0,
            'mg' => $request->mg ?? 0,
            's' => $request->s ?? 0,
            'b' => $request->b ?? 0,
            'mo' => $request->mo ?? 0,
            'fertilizer_wholesale_price' => $request->fertilizer_wholesale_price,
            'fertilizer_semiwholesale_price' => $request->fertilizer_semiwholesale_price,
            'fertilizer_retail_price' => $request->fertilizer_retail_price,
        ]);

        // Save translation
        MineralFertilizerTranslation::create([
            'mineral_fertilizer_id' => $fertilizer->id,
            'language_id' => $languageId,
            'title' => $title,
            'fertilizer_type' => $request->fertilizer_type,
            'fertilizer_registration' => $request->fertilizer_registration ?? '',
            'physical_form' => $request->physical_form ?? '',
            'trade_name' => $request->trade_name ?? '',
            'application_rate' => $request->application_rate ?? '',
            'supplier_id' => $request->supplier_id ?? null,
            'agent_id' => $request->agent_id ?? null,
            'n' => $request->n ?? 0,
            'p2' => $request->p2 ?? 0,
            'k2' => $request->k2 ?? 0,
            'zn' => $request->zn ?? 0,
            'ca' => $request->ca ?? 0,
            'mg' => $request->mg ?? 0,
            's' => $request->s ?? 0,
            'b' => $request->b ?? 0,
            'mo' => $request->mo ?? 0,
            'fertilizer_wholesale_price' => $request->fertilizer_wholesale_price,
            'fertilizer_semiwholesale_price' => $request->fertilizer_semiwholesale_price,
            'fertilizer_retail_price' => $request->fertilizer_retail_price,
        ]);

        DB::commit();

        $fertilizerWithTranslations = MineralFertilizer::with(['seed:id,name', 'translations', 'language'])->find($fertilizer->id);

        return response()->json([
            'status' => true,
            'message' => 'Mineral Fertilizer created successfully',
            'data' => $fertilizerWithTranslations
        ], 201);

    } catch (Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => 'Failed to create Mineral Fertilizer',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * PUT: Update Mineral Fertilizer
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string',
            'seed_id' => 'required|integer',
            'fertilizer_type' => 'required|string',
            'language_id' => 'nullable|integer', 
            'form_type' => 'nullable|string',
            'supplier_id' => 'nullable|integer',
            'agent_id' => 'nullable|integer',
            'created_by' => 'nullable|integer',
            'fertilizer_registration' => 'nullable|string',
            'physical_form' => 'nullable|string',
            'trade_name' => 'nullable|string',
            'application_rate' => 'nullable|string',
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
        ]);

        try {
            DB::beginTransaction();

            $fertilizer = MineralFertilizer::findOrFail($id);

            $languageId = $request->input('language_id', $fertilizer->language_id ?? 1);
            $title = $request->input('title', $fertilizer->title ?? 'Default Fertilizer');

            $fertilizer->update([
                'title' => $title,
                'form_type' => $request->form_type ?? $fertilizer->form_type,
                'fertilizer_type' => $request->fertilizer_type,
                'fertilizer_registration' => $request->fertilizer_registration ?? $fertilizer->fertilizer_registration,
                'physical_form' => $request->physical_form ?? $fertilizer->physical_form,
                'trade_name' => $request->trade_name ?? $fertilizer->trade_name,
                'seed_id' => $request->seed_id,
                'supplier_id' => $request->supplier_id ?? $fertilizer->supplier_id,
                'agent_id' => $request->agent_id ?? $fertilizer->agent_id,
                'created_by' => $request->created_by ?? $fertilizer->created_by,
                'language_id' => $languageId,
                'application_rate' => $request->application_rate ?? $fertilizer->application_rate,
                'n' => $request->n ?? $fertilizer->n,
                'p2' => $request->p2 ?? $fertilizer->p2,
                'k2' => $request->k2 ?? $fertilizer->k2,
                'zn' => $request->zn ?? $fertilizer->zn,
                'ca' => $request->ca ?? $fertilizer->ca,
                'mg' => $request->mg ?? $fertilizer->mg,
                's' => $request->s ?? $fertilizer->s,
                'b' => $request->b ?? $fertilizer->b,
                'mo' => $request->mo ?? $fertilizer->mo,
                'fertilizer_wholesale_price' => $request->fertilizer_wholesale_price,
                'fertilizer_semiwholesale_price' => $request->fertilizer_semiwholesale_price,
                'fertilizer_retail_price' => $request->fertilizer_retail_price,
            ]);

            MineralFertilizerTranslation::updateOrCreate(
                [
                    'mineral_fertilizer_id' => $fertilizer->id,
                    'language_id' => $languageId
                ],
                [
                    'title' => $title,
                    'fertilizer_type' => $request->fertilizer_type,
                    'fertilizer_registration' => $request->fertilizer_registration ?? '',
                    'physical_form' => $request->physical_form ?? '',
                    'trade_name' => $request->trade_name ?? '',
                    'application_rate' => $request->application_rate ?? '',
                    'supplier_id' => $request->supplier_id ?? $fertilizer->supplier_id,
                    'agent_id' => $request->agent_id ?? $fertilizer->agent_id,
                    'n' => $request->n ?? $fertilizer->n,
                    'p2' => $request->p2 ?? $fertilizer->p2,
                    'k2' => $request->k2 ?? $fertilizer->k2,
                    'zn' => $request->zn ?? $fertilizer->zn,
                    'ca' => $request->ca ?? $fertilizer->ca,
                    'mg' => $request->mg ?? $fertilizer->mg,
                    's' => $request->s ?? $fertilizer->s,
                    'b' => $request->b ?? $fertilizer->b,
                    'mo' => $request->mo ?? $fertilizer->mo,
                    'fertilizer_wholesale_price' => $request->fertilizer_wholesale_price,
                    'fertilizer_semiwholesale_price' => $request->fertilizer_semiwholesale_price,
                    'fertilizer_retail_price' => $request->fertilizer_retail_price,
                ]
            );

            DB::commit();

            $fertilizerWithTranslations = MineralFertilizer::with(['seed:id,name', 'translations', 'language'])->find($fertilizer->id);

            return response()->json([
                'status' => true,
                'message' => 'Mineral Fertilizer updated successfully',
                'data' => $fertilizerWithTranslations
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to update Mineral Fertilizer',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
