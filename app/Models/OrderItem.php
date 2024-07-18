<?php

namespace App\Models;

use App\Models\OrderDetail;
use App\Models\ShippingAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
