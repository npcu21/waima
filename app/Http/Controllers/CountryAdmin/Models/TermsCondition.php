<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsCondition extends Model
{
    use HasFactory;

    protected $table = 'terms_conditions';

    protected $fillable = [
        'title',
        'description',
        'language_id'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
