<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    
    protected $table = 'documents';

    protected $fillable = [
        'name',
        'usertype_id',
        'country_id',    // नया field
        'file_path',
        'created_by',
    ];

    // Relation to UserType
    public function usertype()
    {
        return $this->belongsTo(\App\Models\Usertype::class, 'usertype_id', 'id');
    }

    // Relation to Country
    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id', 'id');
    }
}
