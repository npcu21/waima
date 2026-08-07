<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'type'; // your table name
    protected $fillable = ['name_type'];
}
