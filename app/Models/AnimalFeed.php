<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalFeed extends Model
{
    protected $table = 'animal_feeds';

    protected $fillable = [
        'form_type',
        'localProductName',
        'product_id',
        'created_by',
        'supplier_id',
        'agent_id',
        'status_id',
        'reject_reason',
        'language_id',
        'title',
        'Typeoffeed',
        'afrm',
        'afPhysicalform',
        'afdm',
        'afEnergy',
        'afcp',
        'afsp',
        'affs',
        'afWholesalePrice',
        'afsemiwholesalePrice',
        'afretailPrice',
        'qr_code_path',
        'otherRecommendationsPhoto',
                'parent_id',
                                                          'live_id',
                                                          'product_master_id',


    ];

    protected $casts = [
        'afWholesalePrice' => 'decimal:2',
        'afsemiwholesalePrice' => 'decimal:2',
        'afretailPrice' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function supplier()
{
    return $this->belongsTo(Supplier::class, 'supplier_id'); 
    // 'supplier_id' column aapke veterinary_products table me jo supplier id store karta hai
}
public function product()
{
    return $this->belongsTo(Product::class, 'product_master_id');
}

}
