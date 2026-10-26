<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'ine_image_path',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function vendorProfile() {
        return $this->hasOne(VendorProfile::class, 'user_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function favorites() {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class, 'user_id');
    }
}