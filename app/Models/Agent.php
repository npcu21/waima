<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';

    protected $fillable = [
        'usertype_id',
        'name',
        'email',
        'username',
        'password',
        'region',
        'country',
        'country_id',      // ✅ added country_id
        'status_id',
        'reject_message',
        'created_by',
        'language_id',
        'otp',
        'otp_expires_at',
        'device_id',
        'image',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
