<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_type_id',
        'country_id',
        'created_by',
        'status',
        'language_id',
        'currency',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ✅ Relationship to UserType
    public function userType()
    {
        return $this->belongsTo(\App\Models\Usertype::class, 'user_type_id', 'id');
    }

    // ✅ Relationship to creator (User who created the announcement)
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
     public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id', 'id');
    }
}
