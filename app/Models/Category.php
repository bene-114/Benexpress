<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['name', 'type'];

    public function vendorProfiles() {
        return $this->hasMany(VendorProfile::class, 'category_id');
    }

    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }
}