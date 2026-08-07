<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MineralFertilizer extends Model
{
    use HasFactory;

    protected $table = 'mineral_fertilizers';

    protected $fillable = [
        'form_type',
        'title',
        'product_id',
        'fertilizer_type',
        'fertilizer_registration',
        'physical_form',
        'trade_name',
        'n',
        'p2',
        'k2',
        'zn',
        'ca',
        'mg',
        's',
        'b',
        'mo',
        'application_rate',
        'fertilizer_wholesale_price',
        'fertilizer_semiwholesale_price',
        'fertilizer_retail_price',
        'supplier_id',
        'agent_id',
        'created_by',
        'language_id',
        'qr_code_path',
         'status_id', // ✅ यह लाइन add करें
    ];


    // Relation to Seed
   public function seed()
{
    return $this->belongsTo(Seed::class, 'product_id', 'id');
}

    // Relation to Admin who created the record
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    // Relation to Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    // Relation to Agent
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    // Relation to translations (one fertilizer can have many translations)
    public function translations()
    {
        return $this->hasMany(MineralFertilizerTranslation::class, 'mineral_fertilizer_id', 'id');
    }

    // Relation to language (if you want to fetch the language info)
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
      public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
