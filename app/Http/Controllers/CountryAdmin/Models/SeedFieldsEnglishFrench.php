<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedFieldsEnglishFrench extends Model
{
    use HasFactory;

    // Table name exactly same as database
    protected $table = 'seed_fields_english_french';

    protected $fillable = [
        'product_id',
        'language_id',
        'label',
        'name',
        'type',
        'options',
        'required',
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
    ];

    public $timestamps = false;
}
