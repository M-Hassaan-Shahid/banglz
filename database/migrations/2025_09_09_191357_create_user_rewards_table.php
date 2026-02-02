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
        Schema::create('user_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');   // reference users table
            $table->foreignId('bundle_id')->nullable()->constrained()->onDelete('cascade'); // reference bundles table
            $table->enum('type', ['shipping', 'points']); 
            $table->unsignedBigInteger('type_value');
            $table->string('status')->default('pending');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rewards');
    }
};
