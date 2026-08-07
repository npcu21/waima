<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalFeed extends Model
{
    use HasFactory;

    protected $table = 'animal_feeds';

    protected $fillable = [
        'form_type',
        'product_id',
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
        'created_by',
        'supplier_id',  // new
        'agent_id',     // new
        'title',     // new
         'language_id',
          'status_id',
    ];

    // Relationships
    public function seed()
    {
        return $this->belongsTo(Seed::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function translations()
    {
        return $this->hasMany(AnimalFeedTranslation::class);
    }
     public function language()
    {
     
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
     public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
