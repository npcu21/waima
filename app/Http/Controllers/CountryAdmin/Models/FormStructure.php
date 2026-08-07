<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormStructure extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','supplier_id','agent_id','form_json'];

    protected $casts = [
        'form_json' => 'array',
    ];
}
