<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeedField extends Model
{
    protected $table = 'seed_fields';

    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
        'order_no'
    ];

    protected $casts = [
        'required' => 'boolean',
        'options' => 'array'
    ];
}
