<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;

class LanguageApiController extends Controller
{

    public function list()
    {
        $languages = Language::all();

        $response = $languages->map(function($language) {
            return [
                'id'        => $language->id,
                'lang_code' => $language->lang_code,
                'lang_name' => $language->lang_name,
                // 'created_at'=> $language->created_at,
                // 'updated_at'=> $language->updated_at,
            ];
        });

        return response()->json([
            'status'  => true,
            'message' => 'Languages fetched successfully',
            'data'    => $response
        ], 200);
    }
}
