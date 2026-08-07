<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'documents';

    // Fillable fields
    protected $fillable = [
        'name',
        'usertype_id',  // added usertype
        'file_path',
        'created_by',
    ];

    // Relation: Document created by a User
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Relation: Document belongs to a UserType
    
    // Document.php
public function usertype()
{
    return $this->belongsTo(Usertype::class, 'usertype_id', 'id'); // Correct model
}

}
