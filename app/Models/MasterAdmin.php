<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // अगर इसे login के लिए use करना हो
use Illuminate\Notifications\Notifiable;

class MasterAdmin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Table name
     */
    protected $table = 'master_admin';

    /**
     * Fillable fields for mass assignment
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'language_id',
        'country_id',
        'password',
        'created_at',
        'updated_at',
    ];

    /**
     * Hidden fields for arrays/json
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'language_id' => 'integer',
        'country_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
      public function country()
    {
        return $this->belongsTo(Country::class, 'country_id'); 
        // 'country_id' foreign key jo master_admins table me hai
    }
}
