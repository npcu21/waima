<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SyntheticPesticide;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SyntheticPesticideApiController extends Controller
{
    /**
     * ✅ Get all Synthetic Pesticides
     */
    public function index()
    {
        $pesticides = SyntheticPesticide::all(); // fetch all records

        return response()->json([
            'status' => true,
            'message' => 'All Synthetic Pesticides retrieved successfully.',
            'data' => $pesticides
        ], 200);
    }

    /**
     * ✅ Get single Synthetic Pesticide by ID
     */
    public function show($id)
    {
        $pesticide = SyntheticPesticide::find($id);

        if (!$pesticide) {
            return response()->json([
                'status' => false,
                'message' => 'Synthetic Pesticide not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Synthetic Pesticide retrieved successfully.',
            'data' => $pesticide
        ], 200);
    }

    /**
     * ✅ Store new Synthetic Pesticide
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_type' => 'required|string|max:50',
            'trade_name' => 'required|string|max:255',
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
            'seed_id' => 'nullable|exists:seed,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'agent_id' => 'nullable|exists:agents,id',
            'language_id' => 'nullable|exists:languages,id', // ✅ language_id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error.',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Set default language_id if not provided
        $data['language_id'] = $data['language_id'] ?? 1;

        // Set created_by (use Auth if API authentication exists)
        $data['created_by'] = Auth::id() ?? 1;

        $pesticide = SyntheticPesticide::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Synthetic Pesticide created successfully.',
            'data' => $pesticide
        ], 201);
    }
}
