<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
      protected $fillable = [
        'product_id',
        'size',
        'price',
        'compare_price',
        'quantity',
        'unavailable_quantity',
        'member_price',
        'color_id',
        'weight',
        'weight_unit'
        
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'color_id');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'variation_id');
    }

    public function bundleProducts()
    {
        return $this->hasMany(BundleProduct::class, 'variation_id');
    }
}
