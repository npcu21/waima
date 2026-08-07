<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeedFieldsEnglishFrench;

class FormStructureController extends Controller
{
    public function getFormBySeed(Request $request, $product_id)
    {
        $language_id = $request->query('language_id', 1);

        // DB से fetch
        $fields = SeedFieldsEnglishFrench::where('product_id', $product_id)
            ->where('language_id', $language_id)
            ->get(['name as key', 'label', 'type as inputType', 'options', 'required']);

        // options को safely decode करें
        $fields->transform(function ($field) {

            // 🔥 required को boolean में convert (true/false)
            $field->required = filter_var($field->required, FILTER_VALIDATE_BOOLEAN);

            if (!empty($field->options)) {
                if (is_string($field->options)) {
                    $decoded = json_decode($field->options, true);
                    $field->options = is_array($decoded) ? $decoded : [];
                } elseif (is_array($field->options)) {
                    $field->options = $field->options;
                } else {
                    $field->options = [];
                }
            } else {
                $field->options = [];
            }

            $field->value = '';
            return $field;
        });

        $form_types = [
            1 => 'veterinary_products',
            2 => 'animal_feed',
            3 => 'synthetic_pesticides',
            4 => 'inorganic_soil_conditioners',
            5 => 'biostimulants',
            6 => 'organic_amendments',
            7 => 'mineral_fertilizers',
            8 => 'seeds',
        ];

        $form_type = $form_types[$product_id] ?? 'default_form';

        return response()->json([
            'success' => true,
            'product_id' => $product_id,
            'language_id' => $language_id,
            'form_type' => $form_type,
            'data' => $fields
        ]);
    }
}
