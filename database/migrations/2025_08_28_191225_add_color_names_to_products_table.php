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
        Schema::table('products', function (Blueprint $table) {
           $table->json('colors')->nullable();
        });
        // also add in product_variations table
        Schema::table('product_variations', function (Blueprint $table) {
           $table->json('colors')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
              $table->dropColumn('colors');
        });
        Schema::table('product_variations', function (Blueprint $table) {
              $table->dropColumn('colors');
        });
    }
};
