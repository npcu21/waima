<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierTranslate extends Model
{
    protected $fillable = [
        'supplier_id',
        'language_id',
        'company_name',
        'manager_name',
        'position',
        'city',
        'region',
        'address',
        'seed_id', // ✅ added
    ];

    // Cast seed_id to array automatically
    protected $casts = [
        'seed_id' => 'array',
    ];

    /**
     * Translation belongs to a supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Optional helper: Get translation as array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'language_id' => $this->language_id,
            'company_name' => $this->company_name,
            'manager_name' => $this->manager_name,
            'position' => $this->position,
            'city' => $this->city,
            'region' => $this->region,
            'address' => $this->address,
            'seed_id' => $this->seed_id, // ✅ include here too
        ];
    }
}
