<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryApiController extends Controller
{
    // GET /api/countries
    public function index()
    {
        $countries = Country::all();

        return response()->json([
            'status' => true,
            'message' => 'Countries fetched successfully',
            'data' => $countries
        ], 200);
    }
}
