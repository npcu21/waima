<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedForm extends Model
{
    use HasFactory;

    protected $table = 'seed_forms';

    protected $fillable = [
        'form_type',
        'localProductName',
        'title',
        'product_id',
        'language_id',
        'qr_code_path',
        'cropName',
        'verityName',
        'breederName',
        'countryOrigin',
        'registrationNumber',
        'varietyType',
        'seedCategory',
        'precocity',
        'fruitColor',
        'fruitShape',
        'leafLength',
        'leafColor',
        'plantHeight',
        'plantHabit',
        'bioticResistance',
        'abioticResistance',
        'InherentNutritionalValue',
        'other',
        'yield',
        'otherRecommendations',
        'otherRecommendationsPhoto',
        'wholesalePrice',
        'semiwholesalePrice',
        'retailPrice',
        'supplier_id',
        'agent_id',
        'status_id',
        'reject_reason',
        'created_by',
        'parent_id',
                                                  'live_id',
                                                  'product_master_id',

    ];

    // Optional: price fields को float में cast करना
    protected $casts = [
        'wholesalePrice' => 'float',
        'semiwholesalePrice' => 'float',
        'retailPrice' => 'float',
    ];

    // Relations — अगर आप supplier, agent, status जैसी tables से connect करना चाहते हैं
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
