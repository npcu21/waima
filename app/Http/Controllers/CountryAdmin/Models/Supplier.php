<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Status;
use App\Models\SupplierTranslate;
use App\Models\Country;

class Supplier extends Model
{
    protected $fillable = [
        'usertype_id',
        'company_name',
        'name',
        'manager_name',
        'position',
        'image',
        'city',
        'region',
        'address',
        'phone',
        'mobile',
        'email',
        'country_id',
        'created_by',
        'language_id',
        'status_id',
        'state_entity_registration',
        'employer_identification_number',
        'seed_id', // JSON string stored in DB
        'password',
        'otp',
        'enumerator_first_name',
        'enumerator_last_name',
        'enumerator_whatsapp',
        'otp_expires_at',
        'latitude',
        'longitude',
        'altitude',
        'accuracy',
        'reject_message',
        'device_id' // ✅ add reject_message for storing admin reason
    ];

    // Casts
    protected $casts = [
        'seed_id' => 'array', // JSON <-> Array conversion
    ];

    // Relations
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function translations()
    {
        return $this->hasMany(SupplierTranslate::class, 'supplier_id');
    }

    public function translationByLanguage($languageId)
    {
        return $this->translations()->where('language_id', $languageId)->first();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
