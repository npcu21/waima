<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Usertype extends Model
{
    use HasFactory;

    protected $table = 'usertype'; // your table name
    protected $fillable = ['type_name']; // correct column name

    public function users()
    {
        return $this->hasMany(User::class, 'usertype_id');
    }
}
