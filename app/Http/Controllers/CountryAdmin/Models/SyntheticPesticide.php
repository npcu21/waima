<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntheticPesticide extends Model
{
    use HasFactory;

    protected $table = 'synthetic_pesticides';

    protected $fillable = [
        'form_type',
        'trade_name',
        'active_ingredient',
        'other_active_ingredient',
        'formulation',
        'registration_number',
        'function',
        'other_function',
        'toxicological_class_number',
        'approval_number',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
        'product_id',
        'supplier_id',
        'agent_id',
        'created_by',
        'language_id',
         'status_id', // ✅ Added
    ];

    // Default values for NOT NULL fields
    protected $attributes = [
        'wholesale_price' => 0,
        'semiwholesale_price' => 0,
        'retail_price' => 0,
        'language_id' => 1, // ✅ Added default
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

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
      public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
