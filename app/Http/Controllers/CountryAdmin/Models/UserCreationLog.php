<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCreationLog extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'user_creation_log';

    // Disable automatic timestamps (no updated_at column in table)
    public $timestamps = false;

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'usertype_id',
        'country_id',
        'language_id',
        'created_by',
        'created_at' // optional if you want to set it manually
    ];
}
