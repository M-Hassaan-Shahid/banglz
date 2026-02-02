<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCardCodes extends Model
{
    use HasFactory;
    protected $fillable = [
        'recipient_email',
        'code',
        'amount',
        'status',
        'order_id'
    ];

    public function histories()
    {
        return $this->hasMany(GiftCardHistory::class, 'gift_card_id');
    }
 
}
