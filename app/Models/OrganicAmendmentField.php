<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganicAmendmentField extends Model
{
    use HasFactory;

    protected $table = 'organic_amendment_fields';

    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
    ];
}
