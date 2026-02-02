<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BangleBoxColor extends Model
{
    use HasFactory;
    protected $fillable = ['image','color_name','bangle_box_size_id'];

    public function bangleBoxSize()
    {
        return $this->belongsTo(BangleBoxSize::class);
    }
}
