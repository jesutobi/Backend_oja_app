<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class productCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
