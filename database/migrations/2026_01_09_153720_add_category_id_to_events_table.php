<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek dulu, biar tidak error kolom dobel
        if (!Schema::hasColumn('events', 'category_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->foreignId('category_id')
                    ->after('id')
                    ->constrained('categories')
                    ->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('events', 'category_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            });
        }
    }
};
