<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryMessage extends Model
{
    use HasFactory;

    protected $table = 'enquiry_messages';

    protected $fillable = [
        'enquiry_id',
        'sender_id',
        'sender_type',
        'message',
        'file',              // 👈 added
        'seen_by_farmer',
        'seen_by_supplier',
        'seen_at',
        'customer_inqer',
                'status',

    ];
    public function enquiryType()
{
    return $this->belongsTo(\App\Models\EnqeryType::class, 'customer_inqer', 'id');
}

}
