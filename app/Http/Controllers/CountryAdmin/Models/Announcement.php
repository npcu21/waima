<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Type;
use App\Models\User;

class Announcement extends Model
{
    // Fillable fields
    protected $fillable = [
        'title',
        'description',
        'user_type_id',
        'created_by',
         'language_id',
        'status',
         'image',
    ];

    // Relation to Type table (user type)
    public function userType()
    {
        return $this->belongsTo(Type::class, 'user_type_id');
    }
    

    // Relation to User/Admin who created the announcement
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope to filter announcements by creator's language
    public function scopeByCreatorLanguage($query, $languageId)
    {
        return $query->whereHas('creator', function ($q) use ($languageId) {
            $q->where('language_id', $languageId);
        });
    }
}
