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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('email_subscribed')->default(true);
            $table->boolean('marketing_emails')->default(true);
            $table->boolean('order_updates')->default(true);
            $table->boolean('newsletter')->default(false);
            $table->boolean('product_recommendations')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'email_subscribed',
                'marketing_emails',
                'order_updates',
                'newsletter',
                'product_recommendations'
            ]);
        });
    }
};
