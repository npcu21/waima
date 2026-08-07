<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    protected $table = 'price_histories';

    protected $fillable = [
        'product_id',
        'supplier_id',
        'wholesalePrice',
        'semiwholesalePrice',
        'retailPrice',
        'updated_by',
        'add_product_id',
        'changed_at',
    ];

    protected $casts = [
        'wholesalePrice' => 'float',
        'semiwholesalePrice' => 'float',
        'retailPrice' => 'float',
        'changed_at' => 'datetime',
    ];

    // Relations (अगर Product या Supplier की tables हैं)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by'); // या MasterAdmin
    }
}
