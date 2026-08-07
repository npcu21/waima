<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable(); // admin/user ID
            $table->string('status')->default('Active'); // status field
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'status']);
        });
    }
};
