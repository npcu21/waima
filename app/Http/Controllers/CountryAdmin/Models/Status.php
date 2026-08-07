<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $fillable = ['name'];

    public $timestamps = false;

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
}
