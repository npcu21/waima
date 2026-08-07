<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'language_id',
        'country',
        'image',
        'region',      // ✅ नया कॉलम (Region)
        'category',
        'usertype_id',
         'otp',             // ✅ add this
    'otp_expires_at',
    'reject_message',
    'status_id',
    'device_id'
            // ✅ नया कॉलम (Category) 
    ];

    protected $hidden = [
        'password',
    ];
    
    public function translations()
    {
        return $this->hasMany(AgentTranslation::class);
    }
      public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
      public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
