<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'name',
        'code',
                'currency',    // ✅ Add currency
        'language_id',
        'created_by',
    ];

    protected $casts = [
        'language_id' => 'integer',
        'created_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
