<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermCondition extends Model
{
    use HasFactory;

    protected $table = 'terms_conditions';

    protected $fillable = [
        'title',
        'description',
        'language_id',
    ];

    /**
     * Language relation (अगर आप language table से join करना चाहते हैं)
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
