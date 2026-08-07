<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InorganicSoilConditioner extends Model
{
    use HasFactory;

    protected $table = 'inorganic_soil_conditioners';

    protected $fillable = [
        'conditioner_type',
        'localProductName',
        'form_type',
        'product_id',
        'physical_form',
        'trade_name',
        'raw_material',
        'other',
        'function',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
        'qr_code_path',
        'created_by',
        'supplier_id',
        'agent_id',
        'status_id',
        'reject_reason',
        'otherRecommendationsPhoto',
         'parent_id',
                                                   'live_id',
                                                   'product_master_id',

    ];

   
    protected $casts = [
        'wholesale_price' => 'float',
        'semiwholesale_price' => 'float',
        'retail_price' => 'float',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    
}
