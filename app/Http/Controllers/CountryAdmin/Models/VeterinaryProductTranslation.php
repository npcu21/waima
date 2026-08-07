<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeterinaryProductTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'veterinary_product_id',
        'language_id',
        'title',
        'product_name',
        'manufacturing_lab',
        'active_substance',
        'registration_number',
        'therapeutic_class',
        'other_therapeutic_class',
        'dosage',
        'pharmaceutical_form',
        'route_of_administration',
        'targeted_animals',
        'waiting_period',
        'expiry_date',
        'transport_storage_requirements',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
        'supplier_id',
        'agent_id',
        'created_by',
    ];

    public function product() { return $this->belongsTo(VeterinaryProduct::class, 'veterinary_product_id'); }
    public function language() { return $this->belongsTo(Language::class, 'language_id'); }
    public function supplier() { return $this->belongsTo(Supplier::class, 'supplier_id'); }
    public function agent() { return $this->belongsTo(Agent::class, 'agent_id'); }
    public function creator() { return $this->belongsTo(Admin::class, 'created_by'); }
}
