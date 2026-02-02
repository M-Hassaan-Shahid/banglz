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
         Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('variation_id')->nullable();
            
            // if you want foreign key relation with product_variations table
            $table->foreign('variation_id')->references('id')->on('product_variations')->onDelete('cascade');
        });

        Schema::table('bundle_products', function (Blueprint $table) {
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->foreign('variation_id')->references('id')->on('product_variations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
           Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['variation_id']);
            $table->dropColumn('variation_id');
        });

        Schema::table('bundle_products', function (Blueprint $table) {
            $table->dropForeign(['variation_id']);
            $table->dropColumn('variation_id');
        });
    }
};
