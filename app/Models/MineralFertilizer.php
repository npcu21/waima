<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MineralFertilizer extends Model
{
    use HasFactory;

    protected $table = 'mineral_fertilizers';

    protected $fillable = [
        'form_type',
        'localProductName',
        'title',
        'product_id',
        'fertilizer_type',
        'fertilizer_registration',
        'physical_form',
        'trade_name',
        'n',
        'p2',
        'k2',
        'zn',
        'ca',
        'mg',
        's',
        'b',
        'mo',
        'application_rate',
        'fertilizer_wholesale_price',
        'fertilizer_semiwholesale_price',
        'fertilizer_retail_price',
        'qr_code_path',
        'created_by',
        'supplier_id',
        'agent_id',
        'status_id',
        'reject_reason',
        'language_id',
        'created_at',
        'updated_at',
        'otherRecommendationsPhoto',
                 'parent_id',
                                          'live_id',
                                          'product_master_id',

    ];

    /**
     * Casts
     */
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
        'fertilizer_wholesale_price' => 'float',
        'fertilizer_semiwholesale_price' => 'float',
        'fertilizer_retail_price' => 'float',
    ];

    // Optional: Relations if tables exist
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
