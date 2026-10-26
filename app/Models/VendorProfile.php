<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorProfile extends Model
{
    use HasFactory;

    protected $table = 'vendor_profiles';

    protected $fillable = [
        'user_id', 'store_name', 'category_id', 'description', 'clabe', 'status',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products() {
        return $this->hasMany(Product::class, 'vendor_profile_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'vendor_profile_id');
    }
}