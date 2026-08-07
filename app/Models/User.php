<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'usertype_id',
        'country_id',
        'language_id',
        'username',
        'name',
        'email',
        'company_name',
        'manager_name',
        'position',
        'image',
        'city',
        'region',
        'address',
        'phone',
        'mobile',
        'status_id',
        'state_entity_registration',
        'employer_identification_number',
        'latitude',
        'longitude',
        'password',
        'device_id',
        'otp',
        'otp_expires_at',
        'reject_message',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
    ];
    public function usertype()
{
    return $this->belongsTo(\App\Models\Usertype::class, 'usertype_id');
}

public function country()
{
    return $this->belongsTo(\App\Models\Country::class, 'country_id');
}
}
