<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MineralFertilizerField extends Model
{
    use HasFactory;

    protected $table = 'mineral_fertilizer_fields';

    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
        'created_at',
        'updated_at',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'required' => 'boolean',
    ];

    // Optional: Relation to MineralFertilizer if needed
    // public function fertilizer()
    // {
    //     return $this->belongsTo(MineralFertilizer::class, 'fertilizer_id');
    // }
}
