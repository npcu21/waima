<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeterinaryProduct extends Model
{
    use HasFactory;

    protected $table = 'veterinary_products';

    protected $fillable = [
        'form_type',
        'localProductName',
        'title',
        'product_name',
        'manufacturing_lab',
        'active_substance',
        'registration_number',
        'therapeutic_class',
        'other_therapeutic_class',
        'dosage',
        'pharmaceutical_form',
        'route_of_administration',
        'targeted_animals',
        'waiting_period',
        'expiry_date',
        'transport_storage_requirements',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
        'qr_code_path',
        'product_id',
        'created_by',
        'supplier_id',
        'agent_id',
        'status_id',
        'reject_reason',
        'language_id',
        'otherRecommendationsPhoto',
                     'parent_id',
                                          'live_id',


    ];

    public function supplier()
{
    return $this->belongsTo(Supplier::class, 'supplier_id'); 
    // 'supplier_id' column aapke veterinary_products table me jo supplier id store karta hai
}

    // timestamps default true हैं, इसलिए created_at और updated_at automatic handle होंगे
}
