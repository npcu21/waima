<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seed extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'seed';

    // Fillable fields for mass assignment
    protected $fillable = [
        'name',
        'related_table_id',
        'language_id',
        'image', // ✅ Add image field
    ];

    /**
     * Optional: Relation to translations
     */
    public function translations()
    {
        return $this->hasMany(SeedTranslate::class, 'seed_id', 'id');
    }
}
