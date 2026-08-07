<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InorganicSoilConditionerTranslation extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'inorganic_soil_conditioner_translations';

    // Mass assignable fields
    protected $fillable = [
        'inorganic_soil_conditioner_id', // Relation to main conditioner
        'language_id',                    // Language reference
        'conditioner_type',
        'physical_form',
        'trade_name',
        'raw_material',
        'other',
        'function',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
        'created_by',   // optional, copy from main table if needed
        'supplier_id',  // optional
        'agent_id',     // optional
    ];

    /**
     * Relation to main conditioner
     */
    public function conditioner()
    {
        return $this->belongsTo(\App\Models\InorganicSoilConditioner::class, 'inorganic_soil_conditioner_id');
    }

    /**
     * Relation to language
     */
    public function language()
    {
        return $this->belongsTo(\App\Models\Language::class, 'language_id');
    }

    /**
     * Relation to creator (User)
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Relation to supplier
     */
    public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id');
    }

    /**
     * Relation to agent
     */
    public function agent()
    {
        return $this->belongsTo(\App\Models\Agent::class, 'agent_id');
    }
}
