<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedForm extends Model
{
    use HasFactory;

    // 🔹 Laravel को सही table बताएँ
    protected $table = 'seed_forms';

    protected $fillable = [
        'title',
        'form_type',
        'product_id',
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
        'created_by',
        'language_id',

        // ⭐ NEW — status column added
        'status_id',
    ];

    // Relationships
    public function seed()
    {
        return $this->belongsTo(Seed::class, 'seed_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public function translations()
    {
        return $this->hasMany(SeedFormTranslation::class, 'seed_form_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    // ⭐ NEW — status relationship
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
