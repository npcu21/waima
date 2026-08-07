<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BioStimulant extends Model
{
    protected $table = 'bio_stimulants';

    protected $fillable = [
        'form_type',
        'product_id',
        'localProductName',
        'trade_name',
        'physical_form',
        'biostimulant_product',
        're_registration',
        'n',
        'p2',
        'k2',
        'zn',
        'ca',
        'mg',
        's',
        'b',
        'mo',
        'action_mode',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
        'qr_code_path',
        'supplier_id',
        'agent_id',
        'status_id',
        'reject_reason',
        'created_by',
        'language_id',
        'otherRecommendationsPhoto',
        'parent_id',
                                                  'live_id',
                                                  'product_master_id',

        
    ];

    protected $casts = [
        'n' => 'float',
        'p2' => 'float',
        'k2' => 'float',
        'zn' => 'float',
        'ca' => 'float',
        'mg' => 'float',
        's' => 'float',
        'b' => 'float',
        'mo' => 'float',
        'wholesale_price' => 'decimal:2',
        'semiwholesale_price' => 'decimal:2',
        'retail_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function supplier()
{
    return $this->belongsTo(Supplier::class, 'supplier_id'); 
    // 'supplier_id' column aapke veterinary_products table me jo supplier id store karta hai
}

}
