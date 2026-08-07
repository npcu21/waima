<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BioStimulantsField extends Model
{
    use HasFactory;

    // Correct table name
    protected $table = 'bio_stimulants_fields';

    // Fillable fields matching table structure
    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
    ];
}
