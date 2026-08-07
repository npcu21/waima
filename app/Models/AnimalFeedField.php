<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalFeedField extends Model
{
    use HasFactory;

    protected $table = 'animal_feed_fields';  // ✔ Correct table

    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
    ];
}
