<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingAddress extends Model
{
    use HasFactory;
    protected $table = 'shipping_address';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
