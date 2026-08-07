<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerEnquiry extends Model
{
    use HasFactory;

    protected $table = 'farmer_enquiries';

    protected $fillable = [
        'name',
        'email',
        'mobile_no',
        'enquiry_type',
        'supplier_id',
        'language_id',
        'seen_by_farmer',
        'seen_by_supplier',
        'seen_at',
        'description',
        'reply_message',
        'replied_at',
        'created_by',
        'image',
        'pdf',
        'customer_inqer',
        'like_status',
        'status',
    ];

    // ✅ CASTS
    protected $casts = [
        'supplier_id'       => 'array',   // ⭐ IMPORTANT (multiple supplier)
        'seen_by_farmer'    => 'boolean',
        'seen_by_supplier'  => 'boolean',
        'seen_at'           => 'datetime',
        'replied_at'        => 'datetime',
    ];

    // =========================
    // RELATIONS
    // =========================

    // Creator (Farmer / User)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ❌ OLD (remove this – single supplier ke liye tha)
    // public function supplier()
    // {
    //     return $this->belongsTo(Supplier::class, 'supplier_id');
    // }

    // ✅ NEW – Multiple suppliers relation (JSON based)
    public function suppliers()
    {
        return Supplier::whereIn('id', $this->supplier_id ?? [])->get();
    }

    // Enquiry Type
    public function enquiryType()
    {
        return $this->belongsTo(EnqeryType::class, 'enquiry_type', 'id');
    }
}
