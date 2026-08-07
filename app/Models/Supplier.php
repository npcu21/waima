<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'usertype_id',
        'country_id',
        'company_name',
        'manager_name',
        'name',
        'position',
        'image',
        'city',
        'region',
        'address',
        'phone',
        'mobile',
        'email',
        'created_by',
        'language_id',
        'state_entity_registration',
        'employer_identification_number',
        'seed_id',
        'status_id',
        'reject_message',
        'password',
        'otp',
        'otp_expires_at',
        'device_id',
        'enumerator_last_name',
        'enumerator_first_name',
        'enumerator_whatsapp',
        'latitude',
        'longitude',
        'altitude',
        'accuracy'
    ];

    // Relation with Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    // Relation with SeedForms (if supplier has multiple seeds/forms)
    public function seedForms()
    {
        return $this->hasMany(SeedForm::class, 'supplier_id');
    }

    // Relation with Mineral Fertilizers
    public function mineralFertilizers()
    {
        return $this->hasMany(MineralFertilizer::class, 'supplier_id');
    }

    // Relation with Organic Amendments
    public function organicAmendments()
    {
        return $this->hasMany(OrganicAmendment::class, 'supplier_id');
    }
    public function country()
{
    return $this->belongsTo(\App\Models\Country::class, 'country_id');
}

}
