<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InorganicSoilConditionerField extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
        'status'
    ];
}
