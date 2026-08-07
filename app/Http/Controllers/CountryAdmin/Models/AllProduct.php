<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllProduct extends Model
{
    use HasFactory;

    protected $table = 'allproduct';

    protected $fillable = [
        'form_type',
        'product_id',
    ];
}
