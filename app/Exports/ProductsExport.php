<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    protected $data;

    // 👉 LABEL MAP (Correct Place)
    protected $labelMap = [
        'animal_feeds' => [
            'title' => 'Title',
            'Typeoffeed' => 'Raw materials (inputs used in animal feed production)',
            'afrm' => 'Raw materials (inputs used in the production of animal feed)',
            'afPhysicalform' => 'Physical Form',
            'afdm' => '% Dry Matter (DM)',
            'afEnergy' => '% Energy (UF, kcal)',
            'afcp' => '% Crude Protein',
            'afsp' => 'Shelf Life',
            'affs' => 'Feed Supplements',
            'afWholesalePrice' => 'Average Wholesale Price',
            'afsemiwholesalePrice' => 'Average Semi-Wholesale Price',
            'afretailPrice' => 'Average Retail Price',
            'status_id' => 'Status',
            'supplier_id' => 'Supplier ID',
        ],

        'bio_stimulants' => [
            'trade_name' => 'Trade Name',
            'physical_form' => 'Physical Form',
            'biostimulant_product' => 'Biostimulants Product Name',
            're_registration' => 'Registration Number',
            'n' => '%N',
            'p2' => '%P205',
            'k2' => '%K20',
            'zn' => '%Zn',
            'ca' => '%Ca',
            'mg' => '%Mg',
            's' => '%S',
            'b' => '%B',
            'mo' => '%Mo',
            'action_mode' => 'Mode of Action',
            'wholesale_price' => 'Average Wholesale Price',
            'semiwholesale_price' => 'Average Semi-Wholesale Price',
            'retail_price' => 'Average Retail Price',
            'status_id' => 'Status',
        ],

        'inorganic_soil_conditioners' => [
            'conditioner_type' => 'Conditioner Type',
            'physical_form' => 'Physical Form',
            'trade_name' => 'Trade Name',
            'raw_material' => 'Raw Material',
            'function' => 'Function',
            'wholesale_price' => 'Wholesale Price',
            'semiwholesale_price' => 'Semi Wholesale Price',
            'retail_price' => 'Retail Price',
            'status_id' => 'Status',
        ],

        'mineral_fertilizers' => [
            'fertilizer_type' => 'Fertilizer Type',
            'fertilizer_registration' => 'Registration Number',
            'physical_form' => 'Physical Form',
            'trade_name' => 'Trade Name',
            'n' => '%N',
            'p2' => '%P205',
            'k2' => '%K20',
            'zn' => '%Zn',
            'ca' => 'Ca',
            'mg' => '%Mg',
            's' => '%S',
            'b' => '%B',
            'mo' => '%Mo',
            'application_rate' => 'Application Rate per Hectare',
            'status_id' => 'Status',
        ],

        'organic_amendments' => [
            'organic_type' => 'Organic Amendment Type',
            'physical_form' => 'Physical Form',
            'trade_name' => 'Trade Name',
            'country_origin' => 'Country Origin',
            'bio_label' => 'Organic Label',
            'n' => '%N',
            'p2' => '%P205',
            'k2' => '%K20',
            'wholesale_price' => 'Wholesale Price',
            'semiwholesale_price' => 'Semi Wholesale Price',
            'retail_price' => 'Retail Price',
            'status_id' => 'Status',
        ],

        'seed_forms' => [
            'cropName' => 'Crop Name',
            'verityName' => 'Variety Name',
            'breederName' => 'Breeder Name',
            'registrationNumber' => 'Registration Number',
            'yield' => 'Yield (t/ha)',
            'wholesalePrice' => 'Wholesale Price',
            'retailPrice' => 'Retail Price',
            'status_id' => 'Status',
        ],

        'synthetic_pesticides' => [
            'product_name' => 'Product Name',
            'active_substance' => 'Active Ingredient',
            'registration_number' => 'Registration Number',
            'dosage' => 'Dosage',
            'route_of_administration' => 'Route of Administration',
            'status_id' => 'Status',
        ],

        'veterinary_products' => [
            'product_name' => 'Veterinary Product Name',
            'manufacturing_lab' => 'Manufacturing Lab',
            'active_substance' => 'Active Ingredient',
            'dosage' => 'Dosage',
            'route_of_administration' => 'Route of Administration',
            'status_id' => 'Status',
        ]
    ];

    public function __construct($data)
    {
        $this->data = $data;
    }

    // ⭐ Returns full data
    public function collection()
    {
        return $this->data;
    }

    // ⭐ Auto headings + Label mapping
    public function headings(): array
    {
        if ($this->data->isEmpty()) {
            return [];
        }

        $firstRow = (array) $this->data->first();
        $table = $firstRow['table_name'] ?? null;

        return array_map(
            fn($col) => $this->labelMap[$table][$col] ?? ucwords(str_replace('_', ' ', $col)),
            array_keys($firstRow)
        );
    }
}
