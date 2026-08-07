<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seed extends Model
{
    use HasFactory;

    protected $table = 'seed';

    protected $fillable = [
        'name',
        'language_id',
        'related_table_id',
        'image',
    ];

    // Relation with Language
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    // अगर related_table_id किसी table से relation है
    public function relatedTable()
    {
        // Example: अगर related_table_id 'seed_categories' से link है
        return $this->belongsTo(SeedCategory::class, 'related_table_id');
    }
}
