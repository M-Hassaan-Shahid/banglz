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
                   $table->unsignedBigInteger('color_id')->nullable()->after('member_price');
            $table->string('size')->nullable()->after('color_id');

            $table->foreign('color_id')
                  ->references('id')
                  ->on('product_colors')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
         if (Schema::hasColumn('products', 'color_id')) {
                $table->dropForeign(['color_id']);
            }
            $table->dropColumn(['color_id', 'size']);
        });
    }
};
