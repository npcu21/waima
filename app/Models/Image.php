<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'Images';

    // ✅ Disable timestamps to avoid SQL error
    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'image_path',
    ];

    public function parent()
    {
        return $this->belongsTo(Image::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Image::class, 'parent_id');
    }
}
