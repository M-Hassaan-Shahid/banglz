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
            $table->unsignedBigInteger('bangle_box_id')->nullable()->after('type_id');
            $table->string('bangle_box_size')->nullable()->after('bangle_box_id');
            $table->unsignedBigInteger('bangle_size_id')->nullable()->after('bangle_box_size');
            // Add foreign key constraints if necessary
            $table->foreign('bangle_box_id')->references('id')->on('box_sizes')->onDelete('cascade');
            $table->foreign('bangle_size_id')->references('id')->on('bangle_box_sizes')->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['bangle_box_id']);
            $table->dropForeign(['bangle_size_id']);
            $table->dropColumn(['bangle_box_id', 'bangle_box_size', 'bangle_size_id']);
        });
    }
};
