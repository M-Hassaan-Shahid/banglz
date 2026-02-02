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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Unique tag name
            $table->string('slug')->unique()->nullable(); // URL-friendly version of the tag
            $table->text('description')->nullable(); // Optional description of the tag
            $table->boolean('status')->default(1); // Active or inactive status
            $table->string('type')->default('material'); // Type of tag, e.g., 'general', 'featured', etc.
            $table->boolean('top_listed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
