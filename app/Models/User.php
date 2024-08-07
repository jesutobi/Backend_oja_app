<?php

namespace App\Models;

use App\Models\OrderDetail;
use App\Models\SaveProduct;

use App\Models\ProductReview;
use App\Models\ShippingAddress;
use App\Models\emailVerification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function orders()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function savedItems()
    {
        return $this->hasMany(SaveProduct::class);
    }


    // relationship between users and shipping address
    public function addresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }

    // relationship between users and verification token
    public function verificationTokens()
    {
        return $this->hasMany(emailVerification::class);
    }

    // mark the email has verified in the users table
    public function markEmailAsVerified()
    {
        if (!is_null($this->verified_at)) {
            return true;
        }

        $this->forceFill([
            'verified_at' => $this->freshTimestamp(),
        ])->save();

        return true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'first_name',
    //     'last_name',
    //     'email',
    //     'password',
    //     'agree_terms_conditions',
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}
