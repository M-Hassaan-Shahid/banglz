<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'user_id',
        'stripe_pm_id',
        'card_last4',
        'card_brand',
        'exp_month',
        'exp_year',
        'expiry',
        'full_name',
        'street',
        'apartment',
        'city',
        'state',
        'zip',
        'phone',
        'is_default'
    ];

    // convenience accessor -> returns masked card number like "**** **** **** 1234"
    public function getCardNumberAttribute()
    {
        return '**** **** **** ' . ($this->card_last4 ?? '----');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

