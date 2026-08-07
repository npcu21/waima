<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MasterAdmin extends Authenticatable
{
    use Notifiable;

    protected $table = 'master_admin';

    protected $fillable = [
        'name',
        'email',
        'phone',      // ⭐ added
        'password',
        'country_id', // optional now
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Relation: Master Admin belongs to a Country
     */
    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id', 'id');
    }
}
