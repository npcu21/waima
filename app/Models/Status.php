<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';

    protected $fillable = [
        'name',
    ];

    // Optional: timestamps automatic handle
    public $timestamps = true;

    // Relation with SeedForm (one-to-many)
    public function seedForms()
    {
        return $this->hasMany(SeedForm::class, 'status_id');
    }

    // Relation with Mineral Fertilizer
    public function mineralFertilizers()
    {
        return $this->hasMany(MineralFertilizer::class, 'status_id');
    }

    // Relation with Organic Amendment
    public function organicAmendments()
    {
        return $this->hasMany(OrganicAmendment::class, 'status_id');
    }
}
