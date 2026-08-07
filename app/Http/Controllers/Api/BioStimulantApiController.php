<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BioStimulant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BioStimulantApiController extends Controller
{
    /**
     * ✅ Get all Bio-Stimulants (without translations)
     */
    public function index()
    {
        $bioStimulants = BioStimulant::all(); // fetch all records including IDs

        return response()->json([
            'status' => true,
            'message' => 'All Bio-Stimulants retrieved successfully.',
            'data' => $bioStimulants
        ], 200);
    }

    /**
     * ✅ Get single Bio-Stimulant by ID
     */
    public function show($id)
    {
        $bioStimulant = BioStimulant::find($id);

        if (!$bioStimulant) {
            return response()->json([
                'status' => false,
                'message' => 'Bio-Stimulant not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Bio-Stimulant retrieved successfully.',
            'data' => $bioStimulant
        ], 200);
    }

    /**
     * ✅ Store new Bio-Stimulant
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_type' => 'nullable|string|max:255',
            'seed_id' => 'nullable|exists:seed,id',
            'trade_name' => 'required|string|max:255',
            'physical_form' => 'required|string|max:50',
            'biostimulant_product' => 'required|string|max:100',
            're_registration' => 'required|string|max:255',
            'n' => 'nullable|numeric',
            'p2' => 'nullable|numeric',
            'k2' => 'nullable|numeric',
            'zn' => 'nullable|numeric',
            'ca' => 'nullable|numeric',
            'mg' => 'nullable|numeric',
            's' => 'nullable|numeric',
            'b' => 'nullable|numeric',
            'mo' => 'nullable|numeric',
            'action_mode' => 'nullable|string|max:255',
            'wholesale_price' => 'required|numeric',
            'semiwholesale_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'agent_id' => 'nullable|exists:agents,id',
            'language_id' => 'nullable|exists:languages,id', // ✅ add language validation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error.',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Set created_by (use Auth if you have API auth, else default to 1)
        $data['created_by'] = Auth::id() ?? 1;

        // ✅ Set default language_id = 1 if not provided
        $data['language_id'] = $data['language_id'] ?? 1;

        $bioStimulant = BioStimulant::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Bio-Stimulant created successfully.',
            'data' => $bioStimulant
        ], 201);
    }
}
