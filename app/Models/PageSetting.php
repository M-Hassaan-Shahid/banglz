<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    use HasFactory;


     protected $fillable = [
        'page_type',
        'page_name',
        'meta_data',
        'image',
        'images',
        'heading',
        'sub_heading',
        'description',
    ];

    protected $casts = [
        'images' => 'array',
        'meta_data' => 'array',
    ];
}