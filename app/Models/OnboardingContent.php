<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingContent extends Model
{
    use HasFactory;

    protected $table = 'onboarding_contents';

    protected $fillable = [
        'title1',
        'title2',
        'language_id',
        'image',
        'created_at',
        'updated_at',
    ];

    // Optional: Relation to Language if needed
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
