<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntheticPesticide extends Model
{
    use HasFactory;

    protected $table = 'synthetic_pesticides';

    protected $fillable = [
        'form_type',
        'localProductName',
        'trade_name',
        'active_ingredient',
        'other_active_ingredient',
        'formulation',
        'registration_number',
        'function',
        'other_function',
        'toxicological_class_number',
        'approval_number',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
        'qr_code_path',
        'product_id',
        'supplier_id',
        'agent_id',
        'status_id',
        'reject_reason',
        'language_id',
        'created_by',
        'otherRecommendationsPhoto',
                     'parent_id',
                     'live_id',
                     'product_master_id',

    ];

    // Relation with Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // Relation with Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    // Relation with Agent (if you have an Agent model)
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    // Relation with Product (if you have a Product model)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
