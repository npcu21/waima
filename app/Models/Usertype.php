<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $table = 'usertype';

    protected $fillable = [
        'type_name',
        'language_id',
        'created_by',
    ];

    // timestamps default true हैं, इसलिए created_at और updated_at automatic handle होंगे
}
