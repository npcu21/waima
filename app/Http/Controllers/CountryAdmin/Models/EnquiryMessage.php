<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnquiryMessage extends Model
{
    protected $fillable = [
        'enquiry_id',
        'sender_id',
        'sender_type',
        'message',
        'seen_by_farmer',
        'seen_by_supplier',
        'seen_at'
    ];

    public $timestamps = true;
}
