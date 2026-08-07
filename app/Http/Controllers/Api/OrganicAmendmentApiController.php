<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganicAmendment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrganicAmendmentApiController extends Controller
{
    /**
     * ✅ Get all Organic Amendments (safe, only IDs for related models)
     */
     public function index()
    {
        try {
            // Get all data from organic_amendments table
            $organicAmendments = OrganicAmendment::all();

            return response()->json([
                'status' => true,
                'message' => 'All Organic Amendments retrieved successfully.',
                'data' => $organicAmendments
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Organic Amendment GET Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error fetching Organic Amendments.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Get single Organic Amendment by ID
     */
    public function show($id)
    {
        try {
            $organic = OrganicAmendment::find($id);

            if (!$organic) {
                return response()->json([
                    'status' => false,
                    'message' => 'Organic Amendment not found.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Organic Amendment retrieved successfully.',
                'data' => $organic
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Organic Amendment GET Single Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error fetching Organic Amendment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Store new Organic Amendment
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'form_type' => 'nullable|string|max:50',
                'seed_id' => 'nullable|exists:seed,id',
                'organic_type' => 'required|string|max:255',
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
                'wholesale_price' => 'required|numeric',
                'semiwholesale_price' => 'required|numeric',
                'retail_price' => 'required|numeric',
                'supplier_id' => 'nullable|exists:suppliers,id',
                'agent_id' => 'nullable|exists:agents,id',
                'language_id' => 'nullable|exists:languages,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();

            // Defaults
            $data['created_by'] = Auth::id() ?? 1;
            $data['language_id'] = $data['language_id'] ?? 1;
            $data['form_type'] = $data['form_type'] ?? null;
            $data['raw_material'] = isset($data['raw_material']) ? json_encode($data['raw_material']) : '[]';

            $organic = OrganicAmendment::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Organic Amendment created successfully.',
                'data' => $organic
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Organic Amendment Store Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error creating Organic Amendment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Update Organic Amendment
     */
    public function update(Request $request, $id)
    {
        try {
            $organic = OrganicAmendment::find($id);
            if (!$organic) {
                return response()->json([
                    'status' => false,
                    'message' => 'Organic Amendment not found.'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'form_type' => 'nullable|string|max:50',
                'seed_id' => 'nullable|exists:seed,id',
                'organic_type' => 'nullable|string|max:255',
                'physical_form' => 'nullable|string|max:255',
                'trade_name' => 'nullable|string|max:255',
                'country_origin' => 'nullable|string|max:255',
                'bio_label' => 'nullable|string|max:255',
                'n' => 'nullable|integer',
                'p2' => 'nullable|integer',
                'k2' => 'nullable|integer',
                'cao' => 'nullable|integer',
                'mgo' => 'nullable|integer',
                'cn_ratio' => 'nullable|string|max:255',
                'raw_material' => 'nullable|array',
                'raw_material_other' => 'nullable|string|max:255',
                'arsenic_content' => 'nullable|string|max:50',
                'wholesale_price' => 'nullable|numeric',
                'semiwholesale_price' => 'nullable|numeric',
                'retail_price' => 'nullable|numeric',
                'supplier_id' => 'nullable|exists:suppliers,id',
                'agent_id' => 'nullable|exists:agents,id',
                'language_id' => 'nullable|exists:languages,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();

            // Encode raw_material if array
            if (isset($data['raw_material']) && is_array($data['raw_material'])) {
                $data['raw_material'] = json_encode($data['raw_material']);
            }

            $organic->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Organic Amendment updated successfully.',
                'data' => $organic
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Organic Amendment Update Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error updating Organic Amendment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Delete Organic Amendment
     */
    public function destroy($id)
    {
        try {
            $organic = OrganicAmendment::find($id);
            if (!$organic) {
                return response()->json([
                    'status' => false,
                    'message' => 'Organic Amendment not found.'
                ], 404);
            }

            $organic->delete();

            return response()->json([
                'status' => true,
                'message' => 'Organic Amendment deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Organic Amendment Delete Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error deleting Organic Amendment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
