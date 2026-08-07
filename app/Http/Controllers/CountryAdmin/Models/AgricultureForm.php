<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgricultureForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'enumerator_name',
        'enumerator_phone',
        'company_name',
        'manager_name',
        'position',
        'city',
        'region',
        'address',
        'phone',
        'mobile',
        'email',
        'latitude',
        'longitude',
        'altitude',
        'accuracy',
         'seed_id',
    ];
}
