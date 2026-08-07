<?php

namespace App\Exports;

use App\Models\AnimalFeed;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
     * Get all data for export
     */
    public function collection()
    {
        return AnimalFeed::select(
            'id',
            'title',
            'afWholesalePrice',
            'afsemiwholesalePrice',
            'afretailPrice',
            'supplier_id',
            'agent_id',
            'status_id'
        )->get();
    }

    /**
     * Set column headings
     */
    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Wholesale Price',
            'Semiwholesale Price',
            'Retail Price',
            'Supplier ID',
            'Agent ID',
            'Status ID'
        ];
    }
}
