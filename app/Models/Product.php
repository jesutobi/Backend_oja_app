<?php

namespace App\Models;

use App\Models\SaveProduct;
use App\Models\ProductImage;
use App\Models\ProductReview;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = [];
    protected $casts = [
        'product_category' => 'array', // Ensure the JSON field is cast to an array
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function savedItems()
    {
        return $this->hasMany(SaveProduct::class);
    }
    public function category()
    {
        return $this->belongsTo(productCategory::class);
    }
}
