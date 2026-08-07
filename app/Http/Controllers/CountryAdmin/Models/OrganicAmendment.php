<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganicAmendment extends Model
{
    use HasFactory;

    protected $table = 'organic_amendments';

    protected $fillable = [
        'form_type',
        'product_id',
        'organic_type',
        'physical_form',
        'trade_name',
        'country_origin',
        'bio_label',
        'n',
        'p2',
        'k2',
        'cao',
        'mgo',
        'cn_ratio',
        'raw_material',
        'raw_material_other',
        'arsenic_content',
        'wholesale_price',
        'semiwholesale_price',
        'retail_price',
        'supplier_id',     // ✅ added
        'agent_id',        // ✅ added
        'created_by',      // ✅ added
        'language_id',
         'status_id',
    ];

    // ✅ Relationship with Seed
    public function seed()
    {
        return $this->belongsTo(Seed::class, 'seed_id', 'id');
    }

    // ✅ Relationship with Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    // ✅ Relationship with Agent
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    // ✅ Relationship with Admin/Creator
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    // ✅ Relationship with Translations
    public function translations()
    {
        return $this->hasMany(OrganicAmendmentTranslation::class, 'organic_amendment_id', 'id');
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
