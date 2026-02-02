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
            $table->decimal('compare_price', 10, 2)->nullable()->after('price'); // Add compare_price column
$table->integer('quantity')->default(0)->after('compare_price'); // Add quantity column
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->dropColumn('compare_price'); // Remove compare_price column
            $table->dropColumn('quantity'); // Remove quantity column
        });
    }
};
