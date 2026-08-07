<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seed;
use App\Models\SeedForm;
use App\Models\AnimalFeed;
use Illuminate\Support\Facades\Schema;

use App\Models\BioStimulant;
use App\Models\VeterinaryProduct;
use App\Models\InorganicSoilConditioner;
use App\Models\MineralFertilizer;
use App\Models\OrganicAmendment;
use App\Models\SyntheticPesticide;
use Illuminate\Http\Request;

class SeedApiController extends Controller
{
    
public function index(Request $request)
{
   
    $language_id = $request->query('language_id', 1);

    
    $seeds = Seed::where('language_id', $language_id)
        ->get(['name', 'image', 'language_id']);

    $seeds = $seeds->map(function($item, $index) {
        return [
            'id' => $index + 1,  // id 1 से start
            'name' => $item->name,
            'image' => $item->image,
            'language_id' => $item->language_id,
        ];
    });

    return response()->json([
        'success' => true,
        'language_id' => $language_id,
        'data' => $seeds
    ]);
}



    /**
     * GET /api/seed-forms
     * Return a dynamic form structure for each seed
     */
    public function seedForms()
    {
        $seeds = Seed::all();
        $forms = [];

        foreach ($seeds as $seed) {
            $forms[] = [
                [
                    "key" => "supplier_id",
                    "label" => "Supplier ID",
                    "value" => null,
                    "inputType" => "hidden",
                    "required" => false,
                    "placeholder" => "Supplier ID hidden field"
                ],
                [
                    "key" => "seed_id",
                    "label" => "Seed ID",
                    "value" => $seed->id,
                    "inputType" => "hidden",
                    "required" => true,
                    "placeholder" => "Seed ID hidden field"
                ],
                [
                    "key" => "agent_id",
                    "label" => "Agent ID",
                    "value" => null,
                    "inputType" => "hidden",
                    "required" => false,
                    "placeholder" => "Agent ID hidden field"
                ],
                [
                    "key" => "created_by",
                    "label" => "Created By",
                    "value" => null,
                    "inputType" => "hidden",
                    "required" => false,
                    "placeholder" => "Created by hidden field"
                ],
                [
                    "key" => "cropName",
                    "label" => "Crop Name",
                    "value" => "",
                    "inputType" => "text",
                    "required" => true,
                    "placeholder" => "Enter crop name"
                ],
                [
                    "key" => "verityName",
                    "label" => "Variety Name",
                    "value" => "",
                    "inputType" => "text",
                    "required" => true,
                    "placeholder" => "Enter variety name"
                ],
                [
                    "key" => "breederName",
                    "label" => "Breeder's Name",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Enter breeder's name"
                ],
                [
                    "key" => "countryOrigin",
                    "label" => "Country of Origin",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Enter country of origin"
                ],
                [
                    "key" => "registrationNumber",
                    "label" => "Registration Number",
                    "value" => "",
                    "inputType" => "text",
                    "required" => true,
                    "placeholder" => "Enter registration number"
                ],
                [
                    "key" => "varietyType",
                    "label" => "Type of Variety",
                    "value" => "",
                    "inputType" => "radio",
                    "required" => false,
                    "options" => ["Hybrid", "selfPollinated", "openPollinatedVariety"],
                    "placeholder" => "Select type of variety"
                ],
                [
                    "key" => "seedCategory",
                    "label" => "Seed Category",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Example: Breeder, foundation, certified, commercial"
                ],
                [
                    "key" => "precocity",
                    "label" => "Precocity",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Number of days from sowing to ripening"
                ],
                [
                    "key" => "fruitColor",
                    "label" => "Fruit Color",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Enter fruit color"
                ],
                [
                    "key" => "fruitShape",
                    "label" => "Fruit Shape",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Example: Oval Globular, Round Semi-flattened"
                ],
                [
                    "key" => "leafLength",
                    "label" => "Leaf Length",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Enter leaf length"
                ],
                [
                    "key" => "leafColor",
                    "label" => "Leaf Color",
                    "value" => "",
                    "inputType" => "text",
                    "required" => true,
                    "placeholder" => "Example: Dark green, Light green"
                ],
                [
                    "key" => "plantHeight",
                    "label" => "Plant Height (cm)",
                    "value" => "",
                    "inputType" => "text",
                    "required" => true,
                    "placeholder" => "Enter plant height"
                ],
                [
                    "key" => "plantHabit",
                    "label" => "Plant Habit",
                    "value" => "",
                    "inputType" => "radio",
                    "required" => false,
                    "options" => ["erected", "semiErect", "bushy", "virgate", "intracate", "divaricate", "surckers", "coppiceShoots", "lignotuber", "epiphytes", "decumbent", "procumbent", "prostrate", "stoloniferous", "rhizomatous", "pendent"],
                    "placeholder" => "Select plant habit"
                ],
                [
                    "key" => "bioticResistance",
                    "label" => "Biotic Resistance",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Specific resistance/tolerance to biotic factors"
                ],
                [
                    "key" => "abioticResistance",
                    "label" => "Abiotic Resistance",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Specific resistance/tolerance to abiotic factors"
                ],
                [
                    "key" => "InherentNutritionalValue",
                    "label" => "Inherent Nutritional Value",
                    "value" => ["Rich in Beta-carotene", "Rich in Iron", "Rich in Antioxidant"],
                    "inputType" => "checkbox",
                    "required" => false,
                    "options" => ["Rich in Beta-carotene", "Rich in vitamin C", "Rich in Iron", "Rich in Antioxidant", "Other"],
                    "placeholder" => "Select nutritional values"
                ],
                [
                    "key" => "other",
                    "label" => "Other",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Other relevant information"
                ],
                [
                    "key" => "yield",
                    "label" => "Yield (t/ha)",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Enter yield"
                ],
                [
                    "key" => "otherRecommendations",
                    "label" => "Other recommendations (in text)",
                    "value" => "",
                    "inputType" => "text",
                    "required" => false,
                    "placeholder" => "Enter other recommendations"
                ],
                [
                    "key" => "otherRecommendationsPhoto",
                    "label" => "Other recommendations (photo of any support documents)",
                    "value" => "",
                    "inputType" => "file",
                    "required" => false,
                    "placeholder" => "Upload photo"
                ],
                [
                    "key" => "wholesalePrice",
                    "label" => "Average wholesale prices by packaging type*",
                    "value" => null,
                    "inputType" => "text",
                    "required" => true,
                    "placeholder" => "Enter wholesale price"
                ],
                [
                    "key" => "semiwholesalePrice",
                    "label" => "Average semi-wholesalers price by packaging typе*",
                    "value" => null,
                    "inputType" => "text",
                    "required" => true,
                    "placeholder" => "Enter semi-wholesale price"
                ],
                [
                    "key" => "retailPrice",
                    "label" => "Average retail prices by packaging type*",
                    "value" => null,
                    "inputType" => "text",
                    "required" => true,
                    "placeholder" => "Enter retail price"
                ]
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $forms
        ]);
    }
   


    public function categoryCount(Request $request)
{
    $languageId = $request->input('language_id', 1);
    $statusName = strtolower($request->input('status_id')); // active, pending, reject
    $agentId = $request->input('agent_id'); // optional
    $supplierId = $request->input('supplier_id'); // optional

    // Status name => id mapping
    $statusMap = [
        'pending' => 1,
        'active'  => 2,
        'reject'  => 3,
    ];
    $statusId = $statusMap[$statusName] ?? null; // null => show all

    // Selected language wise seeds
    $seeds = Seed::where('language_id', $languageId)->get();

    // Reference seeds (language_id = 1)
    $referenceSeeds = Seed::where('language_id', 1)->get()->keyBy('image');

    $customId = 1;

    $data = $seeds->map(function ($seed) use ($referenceSeeds, $statusId, $agentId, $supplierId, &$customId) {

        $ref = $referenceSeeds->get($seed->image);
        $productsList = [];
        $productCount = 0;

        if ($ref) {
            $seedId = $ref->id;

            $tables = [
                'SeedForm' => \App\Models\SeedForm::class,
                'AnimalFeed' => \App\Models\AnimalFeed::class,
                'BioStimulant' => \App\Models\BioStimulant::class,
                'VeterinaryProduct' => \App\Models\VeterinaryProduct::class,
                'InorganicSoilConditioner' => \App\Models\InorganicSoilConditioner::class,
                'MineralFertilizer' => \App\Models\MineralFertilizer::class,
                'OrganicAmendment' => \App\Models\OrganicAmendment::class,
                'SyntheticPesticide' => \App\Models\SyntheticPesticide::class,
            ];

            foreach ($tables as $tableName => $model) {
                $query = $model::where('product_id', $seedId);

                // Apply status filter
                if ($statusId) {
                    $query->where('status_id', $statusId);
                }

                // Filter by agent_id if passed
                if ($agentId && Schema::hasColumn((new $model)->getTable(), 'agent_id')) {
                    $query->where('agent_id', $agentId);
                }

                // Filter by supplier_id if passed
                if ($supplierId && Schema::hasColumn((new $model)->getTable(), 'supplier_id')) {
                    $query->where('supplier_id', $supplierId);
                }

                $products = $query->get();
                $productCount += $products->count();

                // Add table_name for each product
                $products = $products->map(function ($item) use ($tableName) {
                    $item->table_name = $tableName;
                    return $item;
                });

                $productsList = array_merge($productsList, $products->toArray());
            }
        }

        $imagePath = $seed->image ? url('uploads/seeds/' . $seed->image) : null;

        return [
            'id'             => $customId++,
            'image'          => $imagePath,
            'name'           => $seed->name,
            'product_count'  => $productCount,
            'products'       => $productsList, // full product list
        ];
    });

    return response()->json([
        'success' => true,
        'data'    => $data,
    ]);
}



// public function categoryCount(Request $request)
// {
//     $languageId = $request->input('language_id', 1);
//     $statusName = strtolower($request->input('status_id')); // active, pending, reject

//     // Status name => id mapping
//     $statusMap = [
//         'pending' => 1,
//         'active'  => 2,
//         'reject'  => 3,
//     ];
//     $statusId = $statusMap[$statusName] ?? null; // null => show all

//     // Selected language wise seeds
//     $seeds = Seed::where('language_id', $languageId)->get();

//     // Reference seeds (language_id = 1)
//     $referenceSeeds = Seed::where('language_id', 1)->get()->keyBy('image');

//     $customId = 1;

//     $data = $seeds->map(function ($seed) use ($referenceSeeds, $statusId, &$customId) {

//         $ref = $referenceSeeds->get($seed->image);
//         $productsList = [];

//         $productCount = 0;

//         if ($ref) {
//             $seedId = $ref->id;

//             $tables = [
//                 'SeedForm' => \App\Models\SeedForm::class,
//                 'AnimalFeed' => \App\Models\AnimalFeed::class,
//                 'BioStimulant' => \App\Models\BioStimulant::class,
//                 'VeterinaryProduct' => \App\Models\VeterinaryProduct::class,
//                 'InorganicSoilConditioner' => \App\Models\InorganicSoilConditioner::class,
//                 'MineralFertilizer' => \App\Models\MineralFertilizer::class,
//                 'OrganicAmendment' => \App\Models\OrganicAmendment::class,
//                 'SyntheticPesticide' => \App\Models\SyntheticPesticide::class,
//             ];

//             foreach ($tables as $tableName => $model) {
//                 $query = $model::where('product_id', $seedId);

//                 if ($statusId) {
//                     $query->where('status_id', $statusId);
//                 }

//                 $products = $query->get();
//                 $productCount += $products->count();

//                 // Add table_name for each product
//                 $products = $products->map(function ($item) use ($tableName) {
//                     $item->table_name = $tableName;
//                     return $item;
//                 });

//                 $productsList = array_merge($productsList, $products->toArray());
//             }
//         }

//         $imagePath = $seed->image ? url('uploads/seeds/' . $seed->image) : null;

//         return [
//             'id'             => $customId++,
//             'image'          => $imagePath,
//             'name'           => $seed->name,
//             'product_count'  => $productCount,
//             'products'       => $productsList, // ✅ full product list
//         ];
//     });

//     return response()->json([
//         'success' => true,
//         'data'    => $data,
//     ]);
// }




}
