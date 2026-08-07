<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // Add language_id if it doesn't exist
            if (!Schema::hasColumn('users', 'language_id')) {
                $table->unsignedBigInteger('language_id')->nullable()->after('country_id');

                // Add foreign key safely
                $table->foreign('language_id', 'users_language_id_foreign')
                      ->references('id')
                      ->on('languages')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key if exists
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $foreignKeys = array_map(fn($fk) => $fk->getName(), $sm->listTableForeignKeys('users'));
            if (in_array('users_language_id_foreign', $foreignKeys)) {
                $table->dropForeign('users_language_id_foreign');
            }

            // Drop column if exists
            if (Schema::hasColumn('users', 'language_id')) {
                $table->dropColumn('language_id');
            }
        });
    }
};
