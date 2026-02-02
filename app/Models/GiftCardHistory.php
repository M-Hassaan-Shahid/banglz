<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCardHistory extends Model
{
    use HasFactory;

    protected $table = 'gift_card_histories';
    protected $fillable = ['gift_card_id', 'used_amount'];
    public function giftCard()
    {
        return $this->belongsTo(GiftCardCodes::class, 'gift_card_id');
    }

}
