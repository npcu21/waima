<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreOrderSupplierResponse extends Model
{
    protected $fillable = [
        'pre_order_id',
        'supplier_id',
        'available_quantity',
        'final_price',
        'remarks',
        'status'
    ];
}
