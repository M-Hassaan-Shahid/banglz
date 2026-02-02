<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory , SoftDeletes;
// use fillable to allow mass assignment
    protected $fillable = [
        'name',
        'description',
        'price',
        'compare_price',
        'sku',
        'quantity',
        'images', // Add this line
        'attributes',
        'status',
        'slug',
        'category_id',
        'is_featured',
        'care',
        'sustainability',
        'shipping',
        'returns',
        'member_price',
        'colors',
        'unavailable_quantity',
        'is_top_listed',
        'category_box_id',
        'size',
        'color_id',
        'meta_title',
        'meta_description',
        'images_details',
        'is_pre_order',
        'weight',
        'weight_unit'
    ];

    protected $casts = [
        'images' => 'array',
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }
    public function collection()
    {
        return $this->belongsToMany(Collection::class, 'collection_products', 'product_id', 'collection_id');
    }
    public function variations()
{
    return $this->hasMany(ProductVariation::class);
}
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }
    }
    public function bundleProducts(){
        return $this->hasMany(BundleProduct::class);
    }

    public function color(){
        return $this->belongsTo(ProductColor::class);
    }

}
