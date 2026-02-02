<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{

  protected $table = 'wishlists';
    use HasFactory;
      protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'variation_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }
}
