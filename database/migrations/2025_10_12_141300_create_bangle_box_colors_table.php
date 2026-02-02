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
        Schema::create('bangle_box_colors', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('color_name');
            $table->unsignedBigInteger('bangle_box_size_id')->nullable();
            $table->foreign('bangle_box_size_id')->references('id')->on('bangle_box_sizes')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bangle_box_colors');
    }
};
