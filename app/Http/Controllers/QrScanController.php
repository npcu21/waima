<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QrScanController extends Controller
{
    public function show($type, $id)
    {
        // ✅ Mapping URL slug => database table
        $map = [
            'animalfeed'            => 'animal_feeds',
            'bio-stimulant'         => 'bio_stimulants',
            'inorganic-conditioner' => 'inorganic_soil_conditioners',
            'organic-amendment'     => 'organic_amendments',
            'pesticide'             => 'synthetic_pesticides',
            'synthetic-pesticide'   => 'synthetic_pesticides', // alternative slug
            'veterinary-product'    => 'veterinary_products',
            'seed'                  => 'seed_forms',
            'seed-form'             => 'seed_forms',           // alternative slug
            'mineral-fertilizer'    => 'mineral_fertilizers',  // if you have mineral fertilizer
        ];

        // Normalize type
        $type = strtolower($type);

        if (!isset($map[$type])) {
            abort(404, 'Invalid QR URL');
        }

        $dbTable = $map[$type];

        // Fetch record
        $record = DB::table($dbTable)->where('id', $id)->first();

        if (!$record) {
            return view('qr.notfound', compact('type', 'id'));
        }

        // Convert to array for Blade
        $record = (array) $record;

        // Return QR view
        return view('qr.show', [
            'record'  => $record,
            'dbTable' => $dbTable,
            'typeSlug'=> $type,
        ]);
    }
}
