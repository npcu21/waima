<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeterinaryProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_type',
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
        'product_id',
        'supplier_id',
        'agent_id',
        'created_by',
        'language_id',
         'status_id',
    ];

    public function seed() { return $this->belongsTo(Seed::class, 'seed_id', 'id'); }
    public function supplier() { return $this->belongsTo(Supplier::class, 'supplier_id', 'id'); }
    public function agent() { return $this->belongsTo(Agent::class, 'agent_id', 'id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by', 'id'); }
    public function translations() { return $this->hasMany(VeterinaryProductTranslation::class, 'veterinary_product_id', 'id'); }
      public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
