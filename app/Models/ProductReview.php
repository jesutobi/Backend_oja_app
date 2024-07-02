<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReview extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // A review belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
