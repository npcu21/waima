<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InorganicSoilConditionerField extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'inorganic_soil_conditioner_fields';

    /**
     * Fillable fields for mass assignment
     */
    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * Cast attributes to proper data types
     */
    protected $casts = [
        'required' => 'boolean',
        'status' => 'boolean',
    ];
}
