<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedFormTranslation extends Model
{
    use HasFactory;

    protected $table = 'seed_form_translations';

    protected $fillable = [
        'seed_form_id',       // Reference to main SeedForm
        'language_id',        // Reference to language
        'title',              // ✅ Added title field
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
        'supplier_id',
        'agent_id',
        'created_by',
    ];

    // Relationship with SeedForm
    public function seedForm()
    {
        return $this->belongsTo(SeedForm::class, 'seed_form_id', 'id');
    }

    // Relationship with Language
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    // Relationship with Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    // Relationship with Agent
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    // Relationship with Admin/Creator
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
}
