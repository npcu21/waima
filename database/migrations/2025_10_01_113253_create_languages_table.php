// database/migrations/xxxx_xx_xx_create_languages_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('lang_code', 5)->unique(); // Language code must be unique
            $table->string('lang_name', 50);
            $table->timestamps();
        });

        // Insert default languages
        DB::table('languages')->insert([
            ['lang_code' => 'en', 'lang_name' => 'English'],
            ['lang_code' => 'hi', 'lang_name' => 'Hindi'],
            ['lang_code' => 'bn', 'lang_name' => 'Bengali'],
            ['lang_code' => 'te', 'lang_name' => 'Telugu'],
            ['lang_code' => 'ta', 'lang_name' => 'Tamil'],
            ['lang_code' => 'gu', 'lang_name' => 'Gujarati'],
            ['lang_code' => 'mr', 'lang_name' => 'Marathi'],
            ['lang_code' => 'pa', 'lang_name' => 'Punjabi'],
            ['lang_code' => 'kn', 'lang_name' => 'Kannada'],
            ['lang_code' => 'ur', 'lang_name' => 'Urdu'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
