<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'products_meta_data',
        'total_amount',
        'tax',
        'shipping_fee',
        'status',
        'email',
        'payment_status',
        'user_meta_data',
        'delivery_meta_data',
        'us_import_duties',
        'order_id',
        'us_import_duties',
        'applied_points',
        'applied_shipping',
        'rewards_discount',
        'sub_total',
        'applied_gift_card_meta_data',
        'bangle_box_meta_data'
    ];

    protected $casts = [
        'products_meta_data' => 'array',
        'user_meta_data' => 'array',
        
    ];

    // Relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
  protected static function booted()
{
    static::created(function ($order) {
        $order->order_id = 'ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
        $order->saveQuietly();
    });
}


}
