<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganicAmendment extends Model
{
    use HasFactory;

    protected $table = 'organic_amendments';

    protected $fillable = [
        'form_type',
        'localProductName',
        'product_id',
        'organic_type',
        'physical_form',
        'trade_name',
        'country_origin',
        'bio_label',
        'n',
        'p2',
        'k2',
        'cao',
        'mgo',
        'cn_ratio',
        'raw_material',
        'raw_material_other',
        'arsenic_content',
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
        'copper_content',      // ✅ missing
    'chromium_content',    // ✅ missing
    'lead_content',
    'otherRecommendationsPhoto',
             'parent_id',
                                                       'live_id',


    ];

    protected $casts = [
        'raw_material' => 'array',
        'wholesale_price' => 'float',
        'semiwholesale_price' => 'float',
        'retail_price' => 'float',
    ];

    // Relations (अगर Product, Supplier, Agent, Status की tables हैं)
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
