<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seed;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Agent;
use App\Models\InorganicSoilConditionerTranslation;

class InorganicSoilConditioner extends Model
{
    use HasFactory;

    protected $table = 'inorganic_soil_conditioners';

    protected $fillable = [
        'form_type',
        'product_id',           // relation to seed
        'conditioner_type',
        'physical_form',
        'trade_name',
        'raw_material',
        'other',
        'function',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
        'created_by',        // added
        'supplier_id',       // added
        'agent_id',  
         'status_id',        // added
    ];

    // Relationship with Seed
    public function seed()
    {
        return $this->belongsTo(Seed::class, 'seed_id', 'id');
    }

    // Relationship with creator (User)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship with Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // Relationship with Agent
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    // Relationship with translations
    public function translations()
    {
        return $this->hasMany(InorganicSoilConditionerTranslation::class, 'inorganic_soil_conditioner_id');
    }
      public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
