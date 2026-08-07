<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnimalFeed;
use App\Models\Language;
use App\Models\AnimalFeedTranslation;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Exception;

class AnimalFeedApiController extends Controller
{
    // ✅ GET: All Animal Feeds with translations
    public function index()
    {
        $animalFeeds = AnimalFeed::with('translations')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Animal Feed list fetched successfully',
            'data' => $animalFeeds
        ], 200);
    }

    // ✅ GET: Animal Feed by ID with translations
    public function show($id)
    {
        $animalFeed = AnimalFeed::with('translations')->find($id);

        if (!$animalFeed) {
            return response()->json([
                'status' => 'error',
                'message' => 'Animal Feed not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Animal Feed fetched successfully',
            'data' => $animalFeed
        ], 200);
    }

    // ✅ POST: Create New Animal Feed with translations
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'form_type' => 'nullable|string|max:255',
                'seed_id' => 'nullable|integer',
                'Typeoffeed' => 'nullable|string|max:255',
                'title' => 'nullable|string|max:255',
                'afrm' => 'nullable|string|max:255',
                'afPhysicalform' => 'nullable|string|max:255',
                'afdm' => 'nullable|string|max:255',
                'afEnergy' => 'nullable|string|max:255',
                'afcp' => 'nullable|string|max:255',
                'afsp' => 'nullable|string|max:255',
                'affs' => 'nullable|string|max:255',
                'afWholesalePrice' => 'nullable|numeric',
                'afsemiwholesalePrice' => 'nullable|numeric',
                'afretailPrice' => 'nullable|numeric',
                'supplier_id' => 'nullable|integer',
                'agent_id' => 'nullable|integer',
                'created_by' => 'nullable|integer', // no default
            ]);

            // Set default language_id = 1
            $validated['language_id'] = 1;

            // Create Animal Feed
            $animalFeed = AnimalFeed::create($validated);

            // Ensure numeric fields are properly cast
            $animalFeed->update([
                'afWholesalePrice' => (float)$animalFeed->afWholesalePrice,
                'afsemiwholesalePrice' => (float)$animalFeed->afsemiwholesalePrice,
                'afretailPrice' => (float)$animalFeed->afretailPrice,
            ]);

            // Fetch all languages
            $languages = Language::all();

            $fieldsToTranslate = [
                'title', 'Typeoffeed', 'afrm', 'afPhysicalform',
                'afdm', 'afEnergy', 'afcp', 'afsp', 'affs'
            ];

            foreach ($languages as $lang) {
                if (empty($lang->lang_code)) continue;

                $tr = new GoogleTranslate($lang->lang_code);

                $translationData = [
                    'animal_feed_id' => $animalFeed->id,
                    'language_id' => $lang->id,
                    'supplier_id' => $animalFeed->supplier_id,
                    'agent_id' => $animalFeed->agent_id,
                ];

                foreach ($fieldsToTranslate as $field) {
                    $translationData[$field] = !empty($animalFeed->$field)
                        ? $tr->translate($animalFeed->$field)
                        : null;
                }

                // Prices remain the same in translation
                $translationData['afWholesalePrice'] = $animalFeed->afWholesalePrice;
                $translationData['afsemiwholesalePrice'] = $animalFeed->afsemiwholesalePrice;
                $translationData['afretailPrice'] = $animalFeed->afretailPrice;

                AnimalFeedTranslation::create($translationData);
            }

            // Return created feed with translations
            $animalFeedWithTranslations = AnimalFeed::with('translations')->find($animalFeed->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Animal Feed created successfully with translations',
                'data' => $animalFeedWithTranslations
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
