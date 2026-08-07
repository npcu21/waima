<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllComplementary extends Model
{
    protected $table = 'allcomplementary';

    protected $fillable = [
        'product_id',
        'table_record_id',
        'table_name',
        'title',         // ✅ added title
        'country_id',
        'file_path',
    ];
}
