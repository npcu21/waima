<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's naming convention)
    protected $table = 'regions';

    // Primary key (optional if it's 'id')
    protected $primaryKey = 'id';

    // Fillable fields for mass assignment
    protected $fillable = [
        'country_id',
        'name',
        'created_at',
        'updated_at',
    ];

    // If you want to disable timestamps (not necessary here as you have them)
    // public $timestamps = false;

    /**
     * Relation: Region belongs to a Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
