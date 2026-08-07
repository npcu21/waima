<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MineralFertilizerTranslation extends Model
{
    use HasFactory;

    // Only include columns that exist in the table
    protected $fillable = [
        'mineral_fertilizer_id',
        'title',
        'language_id',
        'fertilizer_type',
        'fertilizer_registration',
        'physical_form',
        'trade_name',
        'application_rate',
        'supplier_id',
        'agent_id',
        'created_by',
    ];

    // Relation to Mineral Fertilizer
    public function fertilizer()
    {
        return $this->belongsTo(MineralFertilizer::class, 'mineral_fertilizer_id', 'id');
    }

    // Relation to Language
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    // Relation to Admin who created it
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    // Relation to Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    // Relation to Agent
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }
}
