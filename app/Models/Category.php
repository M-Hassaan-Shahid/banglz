<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'status',
        'description',
        'images',
        'parent_id',
        'is_featured',
        'top_listed',
        'allow_size'
    ];
    protected $casts = [
        'images' => 'array',
    ];

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function boxes()
{
    return $this->hasMany(CategoryBox::class);
}

}
