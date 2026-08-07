<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntheticPesticidesField extends Model
{
    use HasFactory;

    protected $table = 'synthetic_pesticides_fields';

    protected $fillable = [
        'label',
        'name',
        'type',
        'options',
        'required',
    ];

    // अगर आप चाहते हैं कि ये field किसी specific pesticide से जुड़ी हो
    public function pesticide()
    {
        return $this->belongsTo(SyntheticPesticide::class, 'product_id'); 
        // ध्यान दें: product_id field अगर यहाँ नहीं है तो relation हटा सकते हैं
    }

    /**
     * Field type check helper
     */
    public function isSelect()
    {
        return $this->type === 'select';
    }

    public function isText()
    {
        return $this->type === 'text';
    }

    public function isNumber()
    {
        return $this->type === 'number';
    }

    /**
     * Options as array (JSON decode अगर options JSON में हों)
     */
    public function getOptionsArray()
    {
        return $this->options ? json_decode($this->options, true) : [];
    }
}
