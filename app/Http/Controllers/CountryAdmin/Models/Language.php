<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Language extends Model

{

    use HasFactory;



    protected $fillable = [

        'lang_code',

        'lang_name'

    ];



    public function users()

    {

        return $this->hasMany(User::class, 'language_id');

    }

}

