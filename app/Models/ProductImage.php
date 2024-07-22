<?php

namespace App\Models;

use App\Models\Product;

use App\Models\productCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'product_images';
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function savedItem()
    {
        return $this->hasMany(SaveProduct::class);
    }
    public function category()
    {
        return $this->belongsTo(productCategory::class);
    }
}
