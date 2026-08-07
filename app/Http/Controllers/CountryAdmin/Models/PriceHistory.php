<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    protected $fillable = [
        'product_id',
        'supplier_id',
        'wholesalePrice',
        'semiwholesalePrice',
        'retailPrice',
        'updated_by',
        'changed_at'
    ];

    // Cast timestamps to Carbon
    protected $casts = [
        'changed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
