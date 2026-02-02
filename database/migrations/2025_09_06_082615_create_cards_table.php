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
              Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('stripe_pm_id')->nullable()->index(); // Stripe PaymentMethod id
            $table->string('card_last4', 4)->nullable();         // last 4 digits (safe)
            $table->string('card_brand')->nullable();
            $table->tinyInteger('exp_month')->nullable();
            $table->smallInteger('exp_year')->nullable();
            $table->string('expiry')->nullable();                 // "MM/YY" convenience
            $table->string('full_name')->nullable();
            $table->string('street')->nullable();
            $table->string('apartment')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
