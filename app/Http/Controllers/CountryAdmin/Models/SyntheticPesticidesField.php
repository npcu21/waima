<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntheticPesticidesField extends Model
{
    use HasFactory;

    protected $table = 'synthetic_pesticides_fields';

    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required'
    ];
}
