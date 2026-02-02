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
              Schema::table('product_variations', function (Blueprint $table) {
            // Drop the old JSON column
            if (Schema::hasColumn('product_variations', 'colors')) {
                $table->dropColumn('colors');
            }

            // Add new foreign key column
            $table->unsignedBigInteger('color_id')->nullable()->after('product_id');

            $table->foreign('color_id')
                  ->references('id')
                  ->on('product_colors')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('product_variations', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->dropColumn('color_id');
            $table->json('colors')->nullable();
        });
    }
};
