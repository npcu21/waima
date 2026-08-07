<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedField extends Model
{
    use HasFactory;

    protected $table = 'seed_fields';

    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
    ];
}
