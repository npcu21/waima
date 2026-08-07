<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enqerytype extends Model
{
    use HasFactory;

    // ✅ Table name agar default plural nahi hai
    protected $table = 'enqerytype';

    // ✅ Fillable fields
    protected $fillable = [
        'name',
    ];

    // ✅ Timestamps agar use kar rahe ho
    public $timestamps = true;
}
