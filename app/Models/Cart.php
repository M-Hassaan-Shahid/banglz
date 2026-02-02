<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'type',
        'type_id',
        'user_id',
        'session_id',
        'qty',
        'variation_id',
        'recipient_email',
        'bangle_box_size',
        'bangle_box_id',
        'bangle_size_id',
    ];

      public function product()
    {
        return $this->belongsTo(Product::class, 'type_id');
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class, 'type_id');
    }
    public function bangleCartColors()
    {
        return $this->hasMany(BangleCartColor::class, 'cart_id');
    }
    public function bangleSize()
    {
        return $this->belongsTo(BangleBoxSize::class, 'bangle_size_id');
    }
    public function bangleBox()
    {
        return $this->belongsTo(BoxSize::class, 'bangle_box_id');
    }
}
