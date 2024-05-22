<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class emailVerification extends Model
{
    use HasFactory;
    protected $table = "email_verification";
    // protected $gaurded = ['id'];
    protected $fillable = ['user_id', 'token', 'verified_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
