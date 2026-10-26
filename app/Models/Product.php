<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'vendor_profile_id', 'category_id', 'name', 'description', 'price', 'stock', 'main_image',
    ];

    public function vendor() {
        return $this->belongsTo(VendorProfile::class, 'vendor_profile_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function characteristics() {
        return $this->hasMany(ProductCharacteristic::class, 'product_id');
    }
}