<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PriceTrendExcelExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return array_map(function ($row) {
            return [
                'Product ID'           => $row->product_id ?? '',
                'Date'                 => $row->price_date ?? '',
                'Product Name'         => $row->product_name ?? '',
                'Supplier Name'        => $row->supplier_name ?? '',
                'Company Name'         => $row->company_name ?? '',
                'City'                 => $row->city ?? '',
                'Wholesale Price'      => $row->wholesale_price ?? 0,
                'Semi Wholesale Price' => $row->semiwholesale_price ?? 0,
                'Retail Price'         => $row->retail_price ?? 0,
            ];
        }, $this->data);
    }

    public function headings(): array
    {
        return [
            'Product ID',
            'Date',
            'Product Name',
            'Supplier Name',
            'Company Name',
            'City',
            'Wholesale Price',
            'Semi Wholesale Price',
            'Retail Price',
        ];
    }
}
