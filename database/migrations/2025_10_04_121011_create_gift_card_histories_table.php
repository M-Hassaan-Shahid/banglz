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
        Schema::create('gift_card_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gift_card_id'); 
            $table->decimal('used_amount', 10, 2); 
        $table->timestamps();

            $table->foreign('gift_card_id')
                  ->references('id')->on('gift_card_codes')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_card_histories');
    }
};
