<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    // Table name (optional, अगर table name 'countries' है तो ये जरूरी नहीं)
    protected $table = 'countries';

    // Fillable fields
    protected $fillable = [
        'name',
        'code',
        'language_id',
        'created_by',
    ];

    // Relation: एक country के कई users हो सकते हैं
    public function users()
    {
        return $this->hasMany(User::class, 'country_id', 'id');
    }
}
