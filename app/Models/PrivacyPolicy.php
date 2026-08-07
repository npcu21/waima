<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use HasFactory;

    protected $table = 'privacy_policies';

    protected $fillable = [
        'title',
        'description',
        'language_id',
    ];

    // Relations
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
