<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntheticPesticideTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'synthetic_pesticide_id',
        'language_id',
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
        'supplier_id',
        'agent_id',
        'created_by',
    ];

    public function pesticide()
    {
        return $this->belongsTo(SyntheticPesticide::class, 'synthetic_pesticide_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
