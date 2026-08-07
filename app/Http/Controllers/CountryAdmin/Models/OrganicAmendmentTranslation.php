<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganicAmendmentTranslation extends Model
{
    use HasFactory;

    protected $table = 'organic_amendment_translations';

    protected $fillable = [
        'organic_amendment_id',
        'language_id',
        'organic_type',
        'physical_form',
        'trade_name',
        'country_origin',
        'bio_label',
        'cn_ratio',
        'raw_material',
        'raw_material_other',
        'arsenic_content',
        'supplier_id',
        'agent_id',
        'created_by',
    ];

    // ✅ Relation to main Organic Amendment
    public function organicAmendment()
    {
        return $this->belongsTo(OrganicAmendment::class, 'organic_amendment_id', 'id');
    }

    // ✅ Relation to Language
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    // ✅ Relation to Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    // ✅ Relation to Agent
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    // ✅ Relation to Admin/Creator
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
}
