<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementTranslation extends Model
{
    protected $fillable = [
        'announcement_id',
        'language_id',
        'title',
        'description'
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }
}
