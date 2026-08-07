<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLike extends Model
{
    protected $table = 'product_likes';

    protected $fillable = [
        'product_id',
        'user_id',
        'device_token',

    ];

    // Disable timestamps if table does NOT contain created_at, updated_at
    // If your table has timestamps, remove this line.
    public $timestamps = true;

    /**
     * Relation: like belongs to product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relation: like belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
