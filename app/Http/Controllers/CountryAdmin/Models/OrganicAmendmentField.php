<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganicAmendmentField extends Model
{
    protected $table = 'organic_amendment_fields';

    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
        'order_no'
    ];
}
