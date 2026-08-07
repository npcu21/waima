<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

 protected $fillable = [
    'username',
    'name',
    'email',
    'phone',
    'password',
    'usertype_id',
    'country_id',
    'language_id',
    'otp',
    'otp_expires_at',
    'email_verified_at',

    // ✅ Newly added fields
    'company_name',
    'manager_name',
    'position',
    'image',
    'city',
    'region',
    'address',
    'mobile',
    'status_id',
    'state_entity_registration',
    'employer_identification_number',
    'latitude',
    'longitude',
   'device_id'
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ Automatically hash password only if not already hashed
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            // Avoid double hashing if already hashed
            if (Hash::needsRehash($value)) {
                $this->attributes['password'] = Hash::make($value);
            } else {
                $this->attributes['password'] = $value;
            }
        }
    }

    // ✅ Relationships
    public function usertype()
    {
        return $this->belongsTo(Usertype::class, 'usertype_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    // app/Models/User.php

public function regions()
{
    return $this->belongsToMany(\App\Models\Region::class, 'user_regions', 'user_id', 'region_id');
}

}
