<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DynamicFormController extends Controller
{
    
// public function index(Request $request)
// {
//     $lang = session('lang', 'en'); // 'en' or 'fr'
//     app()->setLocale($lang);
//     $languageId = $lang === 'fr' ? 2 : 1;

//     // Fetch seeds for dropdown that match language
//     $seeds = DB::table('seed')
//         ->where('language_id', $languageId)
//         ->get();

//     $selectedSeedId = $request->get('seed_id');
//     $fields = collect();

//     if ($selectedSeedId) {
//         // Get the actual product_id to fetch fields
//         $seed = DB::table('seed')
//             ->where('id', $selectedSeedId)
//             ->where('language_id', $languageId)
//             ->first();

//         if ($seed) {
//             // Use related_table_id if it exists, otherwise use seed id itself
//             $productId = $seed->related_table_id ?? $seed->id;

//             // Fetch fields
//             $fields = DB::table('seed_fields_english_french')
//                 ->where('product_id', $productId)
//                 ->where('language_id', $languageId)
//                 ->whereNotIn('name', ['created_by','supplier_id','product_id','agent_id','created_at'])
//                 ->get();
//         }
//     }

//     return view('dynamic.dynamic', compact('seeds', 'fields', 'selectedSeedId', 'lang'));
// }
public function index(Request $request)
{
    $lang = session('lang', 'en'); // 'en' or 'fr'
    app()->setLocale($lang);
    $languageId = $lang === 'fr' ? 2 : 1;

    // Fetch seeds for dropdown that match language
    $seeds = DB::table('seed')
        ->where('language_id', $languageId)
        ->get();

    $selectedSeedId = $request->get('seed_id');
    $fields = collect();

    if ($selectedSeedId) {
        // Get the actual product_id to fetch fields
        $seed = DB::table('seed')
            ->where('id', $selectedSeedId)
            ->where('language_id', $languageId)
            ->first();

        if ($seed) {
            // Use related_table_id if it exists, otherwise use seed id itself
            $productId = $seed->related_table_id ?? $seed->id;

            // Fetch fields
            $fields = DB::table('seed_fields_english_french')
                ->where('product_id', $productId)
                ->where('language_id', $languageId)
                ->whereNotIn('name', ['created_by','supplier_id','product_id','agent_id','created_at'])
                ->get();
        }
    }

    // ✅ Fetch countries for dropdown
    $countries = DB::table('countries')->select('id', 'name')->get();
    $selectedCountryId = $request->get('country_id'); // agar selected value chahiye

    return view('dynamic.dynamic', compact('seeds', 'fields', 'selectedSeedId', 'lang', 'countries', 'selectedCountryId'));
}




    /**
     * Show edit form for a single field
     */
    public function edit($id)
    {
        $lang = session('lang', 'en');
        app()->setLocale($lang);
        $languageId = $lang === 'fr' ? 2 : 1;

        $field = $this->getFieldById($id, $languageId);

        if (!$field) {
            return redirect()->route('dynamic.index')
                             ->with('error', __('dashboard.field_not_found'));
        }

        return view('dynamic.edit', compact('field', 'lang'));
    }

    /**
     * Update a single field
     */
    public function update(Request $request, $id)
    {
        $lang = session('lang', 'en');
        app()->setLocale($lang);
        $languageId = $lang === 'fr' ? 2 : 1;

        $field = $this->getFieldById($id, $languageId);

        if (!$field) {
            return redirect()->back()->with('error', __('dashboard.field_not_found'));
        }

        DB::table('seed_fields_english_french')
            ->where('id', $field->id)
            ->update([
                'label' => $request->label,
                'name' => $request->name,
                'type' => $request->type,
                'options' => $request->options,
                'required' => $request->required,
            ]);

        return redirect()->route('dynamic.index', ['seed_id' => $request->input('seed_id')])
                         ->with('success', __('dashboard.fields_updated'));
    }

    /**
     * Update all fields of a selected seed at once
     */
    public function updateAll(Request $request, $seedId)
    {
        $lang = session('lang', 'en');
        app()->setLocale($lang);
        $languageId = $lang === 'fr' ? 2 : 1;

        $fields = $this->getSeedFields($seedId, $languageId);

        foreach($fields as $field) {
            DB::table('seed_fields_english_french')
                ->where('id', $field->id)
                ->update([
                    'label' => $request->input('label_'.$field->id, $field->label),
                    'options' => $request->input('options_'.$field->id, $field->options),
                    'required' => $request->input('required_'.$field->id, $field->required),
                ]);
        }

        return redirect()->route('dynamic.index', ['seed_id' => $seedId])
                         ->with('success', __('dashboard.fields_updated'));
    }

    /**
     * Helper to fetch fields with language fallback
     */
    private function getSeedFields($seedId, $languageId)
    {
        $fields = DB::table('seed_fields_english_french')
            ->where('product_id', $seedId)
            ->where('language_id', $languageId)
            ->get();

        // Fallback to English if no fields in current language
        if ($fields->isEmpty() && $languageId != 1) {
            $fields = DB::table('seed_fields_english_french')
                ->where('product_id', $seedId)
                ->where('language_id', 1)
                ->get();
        }

        return $fields;
    }

    /**
     * Helper to fetch a single field with language fallback
     */
    private function getFieldById($id, $languageId)
    {
        $field = DB::table('seed_fields_english_french')
            ->where('id', $id)
            ->where('language_id', $languageId)
            ->first();

        if (!$field && $languageId != 1) {
            $field = DB::table('seed_fields_english_french')
                ->where('id', $id)
                ->where('language_id', 1)
                ->first();
        }

        return $field;
    }
}
