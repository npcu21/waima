<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedTranslate extends Model
{
    use HasFactory;

    protected $table = 'seed_translates';

    protected $fillable = [
        'seed_id',
        'language_id',
        'translated_name',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
