<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTranslation extends Model
{
    // Table name (agar default plural se alag ho to)
    protected $table = 'user_translations';

    // Fillable fields
    protected $fillable = [
        'user_id',
        'language_id',
        'username',
        'name',
        'email',
        'phone',
        'email_verified_at',
        'password',
        'remember_token',
        'otp',
        'otp_expires_at',
        'created_at',
        'updated_at'
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
