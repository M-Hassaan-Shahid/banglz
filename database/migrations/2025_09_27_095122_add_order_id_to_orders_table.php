<?php

use App\Models\Order;
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
        Schema::table('orders', function (Blueprint $table) {
                       $table->string('order_id')->unique()->nullable()->after('id');
                       $table->string('applied_points')->nullable()->default('0')->after('order_id');
                       $table->string('rewards_discount')->nullable()->default('0')->after('applied_points');
                       $table->boolean('applied_shipping')->nullable()->default(0)->after('rewards_discount');
                       $table->string('sub_total')->nullable()->default('0')->after('applied_shipping');
                   });
         $orders = Order::all();
    foreach ($orders as $order) {
        $order->order_id = 'ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
        $order->save();
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
           $table->dropColumn('order_id','applied_points','rewards_discount','applied_shipping','sub_total');
        });
    }
};
