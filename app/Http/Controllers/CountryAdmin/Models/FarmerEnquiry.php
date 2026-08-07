<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerEnquiry extends Model
{
    use HasFactory;
protected $fillable = [
    'name',
    'email',
    'mobile_no',
    'enquiry_type',
    'description',
    'created_by',
    'supplier_id',
    'seen_by_supplier',
    'seen_at',
    'reply_message',
    'replied_at',
    'language_id'
];

    // Farmer enquiry किस seed से related है
    public function seed()
    {
        return $this->belongsTo(Seed::class, 'enquiry_type');
    }

    // Farmer enquiry किस user ने बनाई
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Supplier जो इस enquiry को handle कर रहा
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
