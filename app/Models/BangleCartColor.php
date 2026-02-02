<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BangleCartColor extends Model
{
    use HasFactory;

    protected $table = 'bangle_cart_colors';

    protected $fillable = [
        'cart_id',
        'color_id',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function color()
    {
        return $this->belongsTo(BangleBoxColor::class);
    }
}
