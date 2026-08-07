<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'languages';

    /**
     * Fillable fields for mass assignment
     */
    protected $fillable = [
        'lang_code',
        'lang_name',
        'created_at',
        'updated_at',
    ];

    /**
     * Timestamps are enabled by default, 
     * so no need to declare $timestamps unless you want to disable them
     */
}
