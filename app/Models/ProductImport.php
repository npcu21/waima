<?php

namespace App\Imports;

use App\Models\AnimalFeed;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * Map each row from Excel to the AnimalFeed model
     */
    public function model(array $row)
    {
        return new AnimalFeed([
            'title'                 => $row['title'] ?? null,
            'supplier_id'           => $row['supplier_id'] ?? null,
            'agent_id'              => $row['agent_id'] ?? null, // Added agent_id in case Excel has it
            'status_id'             => $row['status_id'] ?? 1,   // Default to 1 if not provided
            'afWholesalePrice'      => $row['afwholesaleprice'] ?? null,
            'afsemiwholesalePrice'  => $row['afsemiwholesaleprice'] ?? null,
            'afretailPrice'         => $row['afretailprice'] ?? null,
            'form_type'             => $row['form_type'] ?? 'animal_feed',
            'Typeoffeed'            => $row['typeoffeed'] ?? null,
            'afrm'                  => $row['afrm'] ?? null,
            'afPhysicalform'        => $row['afphysicalform'] ?? null,
            'afdm'                  => $row['afdm'] ?? null,
            'afEnergy'              => $row['afenergy'] ?? null,
            'afcp'                  => $row['afcp'] ?? null,
            'afsp'                  => $row['afsp'] ?? null,
            'affs'                  => $row['affs'] ?? null,
        ]);
    }
}
