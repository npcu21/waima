<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BioStimulant extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_type',
        'product_id',           // ✅ Seed relation
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
        'supplier_id',       // ✅ Supplier relation
        'agent_id',          // ✅ Agent relation
        'created_by',        // ✅ Created by admin
        'language_id', 
         'status_id',      // ✅ Language relation
    ];

    // Relationship with Seed
    public function seed()
    {
        return $this->belongsTo(\App\Models\Seed::class, 'seed_id', 'id');
    }

    // Relationship with Supplier
    public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id', 'id');
    }

    // Relationship with Agent
    public function agent()
    {
        return $this->belongsTo(\App\Models\Agent::class, 'agent_id', 'id');
    }

    // Relationship with Creator (Admin who created this record)
    public function creator()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'created_by', 'id');
    }

    // Relationship with Language
    public function language()
    {
        return $this->belongsTo(\App\Models\Language::class, 'language_id', 'id');
    }

    // Relationship with Translations
    public function translations()
    {
        return $this->hasMany(\App\Models\BioStimulantTranslation::class, 'bio_stimulant_id', 'id');
    }
      public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
