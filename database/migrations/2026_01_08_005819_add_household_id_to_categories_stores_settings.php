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
        // Add household_id to categories
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('household_id')->nullable()->constrained()->onDelete('cascade');
        });

        // Add household_id to stores
        Schema::table('stores', function (Blueprint $table) {
            $table->foreignId('household_id')->nullable()->constrained()->onDelete('cascade');
        });

        // Add household_id to settings
        Schema::table('settings', function (Blueprint $table) {
            $table->foreignId('household_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['household_id']);
            $table->dropColumn('household_id');
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign(['household_id']);
            $table->dropColumn('household_id');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign(['household_id']);
            $table->dropColumn('household_id');
        });
    }
};
