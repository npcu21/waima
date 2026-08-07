<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreOrder extends Model
{
    protected $fillable = [
           'farmer_id',
        'supplier_id',
        'product_id',
        'quantity',
        'location',
        'description',
        'order_type',
        'status'
    ];

    public function supplierResponse()
    {
        return $this->hasOne(PreOrderSupplierResponse::class);
    }
}
