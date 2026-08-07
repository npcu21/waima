<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BioStimulantTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bio_stimulant_id',       // reference to main bio-stimulant
        'language_id',            // language
        'trade_name',
        'physical_form',
        'biostimulant_product',
        're_registration',
        'action_mode',
        'n',
        'p2',
        'k2',
        'zn',
        'ca',
        'mg',
        's',
        'b',
        'mo',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
        'supplier_id',
        'agent_id',
    ];

    // Relationship with main Bio-Stimulant
    public function bioStimulant()
    {
        return $this->belongsTo(BioStimulant::class, 'bio_stimulant_id', 'id');
    }

    // Relationship with Language
    public function language()
    {
        return $this->belongsTo(\App\Models\Language::class, 'language_id', 'id');
    }

    // Optional: Supplier relation
    public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id', 'id');
    }

    // Optional: Agent relation
    public function agent()
    {
        return $this->belongsTo(\App\Models\Agent::class, 'agent_id', 'id');
    }
}
