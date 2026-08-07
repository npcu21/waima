<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usertype;
use Illuminate\Support\Facades\Validator;

class UserTypeController extends Controller
{
    // GET /api/usertypes
    public function index()
    {
        try {
            $usertypes = Usertype::all(['id', 'type_name', 'created_at', 'updated_at']);
            return response()->json([
                'status' => true,
                'message' => 'User types fetched successfully',
                'data' => $usertypes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch user types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST /api/usertypes
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_name' => 'required|string|unique:usertype,type_name'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $usertype = Usertype::create([
                'type_name' => $request->type_name
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User type created successfully',
                'data' => $usertype
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create user type',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
