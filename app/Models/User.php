<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type', // Added type attribute
        'last_name',
        'address',
        'country',
        'latitude',
        'longitude',
        'session_id', // Added session_id attribute
        'stripe_customer_id',
        'total_points',
        'total_shippings',
        'is_guest',
        'customer_id',
        'email_subscribed',
        'marketing_emails',
        'order_updates',
        'newsletter',
        'product_recommendations',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'email_subscribed' => 'boolean',
        'marketing_emails' => 'boolean',
        'order_updates' => 'boolean',
        'newsletter' => 'boolean',
        'product_recommendations' => 'boolean',
    ];
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all addresses for the user.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Check if user can add more addresses (max 3).
     */
    public function canAddAddress(): bool
    {
        return $this->addresses()->count() < 3;
    }
}
