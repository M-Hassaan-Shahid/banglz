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
              Schema::table('products', function (Blueprint $table) {
            $table->string('weight')->nullable(); // adjust position if needed
        });

        Schema::table('product_variations', function (Blueprint $table) {
            $table->string('weight')->nullable(); // or after any other relevant column
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('weight');
        });

        Schema::table('product_variations', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }
};
