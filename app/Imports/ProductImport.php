<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class ProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $productId = $row['product_id'] ?? null;

            if (!$productId) {
                continue; // skip row if product_id missing
            }

            switch ($productId) {

                // 1️⃣ Veterinary Products
                case 1:
                    DB::table('veterinary_products')->insert([
                        'product_id' => $productId, // ✅ added
                        'form_type' => $row['form_type'] ?? 'veterinary',
                        'product_name' => $row['product_name'],
                        'registration_number' => $row['registration_number'],
                        'wholesale_price' => $row['wholesale_price'],
                        'semiwholesale_price' => $row['semiwholesale_price'],
                        'retail_price' => $row['retail_price'],
                        'supplier_id' => $row['supplier_id'],
                        'agent_id' => $row['agent_id'],
                        'status_id' => $row['status_id'] ?? 1,
                        'created_by' => $row['created_by'],
                        'language_id' => $row['language_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                // 2️⃣ Animal Feed
                case 2:
                    DB::table('animal_feeds')->insert([
                        'product_id' => $productId, // ✅ added
                        'form_type' => 'animal_feed',
                        'title' => $row['title'],
                        'Typeoffeed' => $row['typeoffeed'],
                        'afPhysicalform' => $row['afphysicalform'],
                        'afWholesalePrice' => $row['afwholesaleprice'],
                        'afsemiwholesalePrice' => $row['afsemiwholesaleprice'],
                        'afretailPrice' => $row['afretailprice'],
                        'supplier_id' => $row['supplier_id'],
                        'agent_id' => $row['agent_id'],
                        'status_id' => $row['status_id'] ?? 1,
                        'created_by' => $row['created_by'],
                        'language_id' => $row['language_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                // 3️⃣ Synthetic Pesticides
              case 3:

    // 🔒 Required validation
    if (
        empty($productId) ||
        empty($row['trade_name']) ||
        empty($row['registration_number']) ||
        empty($row['approval_number'])
    ) {
        break; // required field missing → skip row
    }

    DB::table('synthetic_pesticides')->insert([
        'product_id' => $productId, // 🔒 REQUIRED
        'form_type' => $row['form_type'] ?? 'synthetic_pesticide',
        'trade_name' => $row['trade_name'],
        'registration_number' => $row['registration_number'],
        'approval_number' => $row['approval_number'], // 🔒 REQUIRED

        // Optional fields
        'active_ingredient' => $row['active_ingredient'] ?? null,
        'other_active_ingredient' => $row['other_active_ingredient'] ?? null,
        'formulation' => $row['formulation'] ?? null,
        'function' => $row['function'] ?? null,
        'other_function' => $row['other_function'] ?? null,
        'toxicological_class_number' => $row['toxicological_class_number'] ?? null,

        'wholesale_price' => $row['wholesale_price'] ?? null,
        'semiwholesale_price' => $row['semiwholesale_price'] ?? null,
        'retail_price' => $row['retail_price'] ?? null,

        'supplier_id' => $row['supplier_id'] ?? null,
        'agent_id' => $row['agent_id'] ?? null,
        'status_id' => $row['status_id'] ?? 1,
        'language_id' => $row['language_id'] ?? 1,
        'created_by' => $row['created_by'] ?? null,

        'created_at' => now(),
        'updated_at' => now(),
    ]);
    break;


                // 4️⃣ Inorganic Soil Conditioners
           case 4:

    // ✅ product_id required check
    if (empty($productId)) {
        break; // product_id nahi hai to insert skip
    }

    // ✅ physical_form required check (optional but safe)
    if (empty($row['physical_form'])) {
        break;
    }

    DB::table('inorganic_soil_conditioners')->insert([
        'product_id' => $productId, // 🔒 REQUIRED
        'conditioner_type' => $row['conditioner_type'],
        'form_type' => $row['form_type'] ?? 'inorganic_soil_conditioner',
        'physical_form' => $row['physical_form'], // 🔒 REQUIRED
        'trade_name' => $row['trade_name'],
        'wholesale_price' => $row['wholesale_price'],
        'semiwholesale_price' => $row['semiwholesale_price'],
        'retail_price' => $row['retail_price'],
        'created_by' => $row['created_by'],
         'status_id' => $row['status_id'] ?? 1,
'supplier_id' => $row['supplier_id'],
                        'agent_id' => $row['agent_id'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    break;


                // 5️⃣ Biostimulants
                case 5:
                    DB::table('bio_stimulants')->insert([
                        'product_id' => $productId, // ✅ added
                        'trade_name' => $row['trade_name'],
                        'physical_form' => $row['physical_form'],
                        'wholesale_price' => $row['wholesale_price'],
                        'semiwholesale_price' => $row['semiwholesale_price'],
                        'retail_price' => $row['retail_price'],
                        'created_by' => $row['created_by'],
                                'status_id' => $row['status_id'] ?? 1,
                                'supplier_id' => $row['supplier_id'],
                        'agent_id' => $row['agent_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                // 6️⃣ Organic Amendments
          case 6:

    // 🔒 Required validation
    if (
        empty($productId) ||
        empty($row['organic_type']) ||
        empty($row['physical_form']) ||
        empty($row['trade_name']) ||
        empty($row['country_origin']) ||
        empty($row['bio_label'])
    ) {
        break; // skip row if any required field missing
    }

    DB::table('organic_amendments')->insert([
        'product_id' => $productId, // 🔒 REQUIRED
        'form_type' => $row['form_type'] ?? 'organic_amendment',
        'organic_type' => $row['organic_type'],
        'physical_form' => $row['physical_form'],
        'trade_name' => $row['trade_name'],
        'country_origin' => $row['country_origin'], // 🔒 REQUIRED
        'bio_label' => $row['bio_label'],           // 🔒 REQUIRED

        // Optional / defaulted numeric fields
        'n' => $row['n'] ?? 0,
        'p2' => $row['p2'] ?? 0,
        'k2' => $row['k2'] ?? 0,
        'cao' => $row['cao'] ?? 0,
        'mgo' => $row['mgo'] ?? 0,
                               'status_id' => $row['status_id'] ?? 1,
'supplier_id' => $row['supplier_id'],
                        'agent_id' => $row['agent_id'],
        'wholesale_price' => $row['wholesale_price'] ?? 0,
        'semiwholesale_price' => $row['semiwholesale_price'] ?? 0,
        'retail_price' => $row['retail_price'] ?? 0,

        'created_by' => $row['created_by'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    break;


                // 7️⃣ Mineral Fertilizers
                case 7:
                    DB::table('mineral_fertilizers')->insert([
                        'product_id' => $productId, // ✅ added
                        'fertilizer_type' => $row['fertilizer_type'],
                        'fertilizer_registration' => $row['fertilizer_registration'],
                        'physical_form' => $row['physical_form'],
                        'fertilizer_wholesale_price' => $row['fertilizer_wholesale_price'],
                        'fertilizer_semiwholesale_price' => $row['fertilizer_semiwholesale_price'],
                        'fertilizer_retail_price' => $row['fertilizer_retail_price'],
                        'created_by' => $row['created_by'],
                                                'status_id' => $row['status_id'] ?? 1,
'supplier_id' => $row['supplier_id'],
                        'agent_id' => $row['agent_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                // 8️⃣ Seeds
                case 8:
                    DB::table('seed_forms')->insert([
                        'product_id' => $productId, // ✅ added
                        'form_type' => $row['form_type'] ?? 'seed',
                        'cropName' => $row['cropname'],
                        'verityName' => $row['verityname'],
                        'registrationNumber' => $row['registrationnumber'],
                        'wholesalePrice' => $row['wholesaleprice'],
                        'semiwholesalePrice' => $row['semiwholesaleprice'],
                        'retailPrice' => $row['retailprice'],
                        'created_by' => $row['created_by'],
                                                'status_id' => $row['status_id'] ?? 1,
'supplier_id' => $row['supplier_id'],
                        'agent_id' => $row['agent_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;
            }
        }
    }
}
