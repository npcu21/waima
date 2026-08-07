<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeterinaryProductField extends Model
{
    use HasFactory;

    protected $table = 'veterinary_products_fields';

    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
    ];

    // timestamps default true हैं, इसलिए created_at और updated_at automatic handle होंगे

    // Relationship with veterinary_products (optional)
    public function veterinaryProduct()
    {
        return $this->belongsTo(VeterinaryProduct::class, 'product_id');
    }
}
