<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title1',
        'title2',
        'language_id',
        'image'
    ];

    // Language Relation (Optional)
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
