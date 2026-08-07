<?php

namespace App\Http\Controllers;

use App\Models\Seed;
use App\Models\SeedTranslate;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Exception;
use Illuminate\Support\Facades\Auth;

class SeedController extends Controller
{
    public function index()
    {
        $seeds = Seed::all();
        $languages = \App\Models\Language::all();
        $translatedSeeds = [];

        foreach ($seeds as $seed) {
            $translations = [];
            foreach ($languages as $lang) {
                $existing = SeedTranslate::firstOrCreate(
                    [
                        'seed_id' => $seed->id,
                        'language_id' => $lang->id,
                    ],
                    [
                        'translated_name' => $this->translateText($seed->name, $lang->lang_code)
                    ]
                );
                $translations[$lang->lang_name] = $existing->translated_name;
            }

            $translatedSeeds[] = [
                'id' => $seed->id,
                'original_name' => $seed->name,
                'translations' => $translations,
            ];
        }

        return view('admin.products.seed_list', compact('translatedSeeds', 'languages'));
    }

    // ✅ Show create form
    public function create()
    {
        $languages = \App\Models\Language::all();
        return view('admin.products.seed_create', compact('languages'));
    }

    // ✅ Store seed with image upload
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'language_id' => 'nullable|exists:languages,id',
            'related_table_id' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();

            if (!file_exists(public_path('uploads/seeds'))) {
                mkdir(public_path('uploads/seeds'), 0777, true);
            }

            $file->move(public_path('uploads/seeds'), $filename);
            $validated['image'] = $filename;
        }

        // Default language_id
        $validated['language_id'] = $validated['language_id'] ?? 1;

        // Save seed
        $seed = Seed::create($validated);

        // ✅ Optional: Translate seed name for all languages
        $languages = \App\Models\Language::all();
        foreach ($languages as $lang) {
            SeedTranslate::firstOrCreate(
                [
                    'seed_id' => $seed->id,
                    'language_id' => $lang->id
                ],
                [
                    'translated_name' => $this->translateText($seed->name, $lang->lang_code)
                ]
            );
        }

        return redirect()->back()->with('success', 'Seed saved successfully!');
    }

    // Translate text safely using Google Translate
    private function translateText($text, $langCode)
    {
        try {
            $translator = new GoogleTranslate($langCode);
            return $translator->translate($text);
        } catch (Exception $e) {
            return $text; // fallback
        }
    }
}
