<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_name',
        'variety_name',
        'breeder_name',
        'country_origin',
        'registration_number',
        'variety_type',
        'seed_category',
        'precocity',
        'fruit_color',
        'fruit_shape',
        'leaf_length',
        'leaf_color',
        'plant_height',
        'plant_habit',
        'biotic_resistance',
        'abiotic_resistance',
        'nutritional_value',
        'yield',
        'other_recommendations',
        'other_recommendations_photo',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
    ];
}
