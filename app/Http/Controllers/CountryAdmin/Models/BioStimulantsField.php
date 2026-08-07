<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BioStimulantsField extends Model
{
    protected $table = 'bio_stimulants_fields';
    protected $fillable = ['label','name','type','options','required'];
}
