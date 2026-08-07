<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    use HasFactory;

    protected $table = 'suppliers'; // exact table name
    protected $fillable = [
        'company_name', 
        'manager_name', 
        'position', 
        'city', 
        'region', 
        'address', 
        'phone', 
        'mobile', 
        'email',
        'created_by'
    ];
}
