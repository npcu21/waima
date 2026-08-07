<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalFeedTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_feed_id',
        'language_id',
        'Typeoffeed',
        'afrm',
        'afPhysicalform',
        'afdm',
        'afEnergy',
        'afcp',
        'afsp',
        'affs',
        'afWholesalePrice',
        'afsemiwholesalePrice',
        'afretailPrice',
        'supplier_id', // new
        'agent_id',    // new
        'title',    // new
    ];

    public function animalFeed()
    {
        return $this->belongsTo(AnimalFeed::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
