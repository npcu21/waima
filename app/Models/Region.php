<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'regions';

    protected $fillable = [
        'name_en',
        'name_fr',
        'country_id',
        'name',
        'commune',
        'district',
    ];

    // Relation with Country
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
