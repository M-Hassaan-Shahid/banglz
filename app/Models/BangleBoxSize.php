<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BangleBoxSize extends Model
{
    use HasFactory;

    protected $fillable = ['size'];

    public function bangleBoxColors()
    {
        return $this->hasMany(BangleBoxColor::class);
    }
}
