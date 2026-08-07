<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VeterinaryProduct;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;

class VeterinaryProductApiController extends Controller
{
    // 🔹 Store new Veterinary Product
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'form_type' => 'nullable|string|max:50', // make nullable
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
                'seed_id' => 'nullable|integer',
                'supplier_id' => 'nullable|integer',
                'agent_id' => 'nullable|integer',
                'language_id' => 'nullable|integer',
            ]);

            // 🔹 Set defaults if not provided
            $validated['form_type'] = $validated['form_type'] ?? 'veterinary';
            $validated['language_id'] = $validated['language_id'] ?? 1;
            $validated['created_by'] = Session::get('user_id') ?? 1;

            // 🔹 Save data to DB
            $product = VeterinaryProduct::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Veterinary product saved successfully!',
                'data' => $product
            ], 201);

        } catch (Exception $e) {
            Log::error('Veterinary Product Save Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error saving product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 🔹 List all products
    public function index()
    {
        $products = VeterinaryProduct::all();
        return response()->json($products);
    }

    // 🔹 Fetch single product by ID
    public function show($id)
    {
        try {
            $product = VeterinaryProduct::find($id);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Veterinary product not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Veterinary product fetched successfully',
                'data' => $product
            ], 200);

        } catch (Exception $e) {
            Log::error('Veterinary Product Fetch Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error fetching product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
