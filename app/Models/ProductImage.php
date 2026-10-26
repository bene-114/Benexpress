<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';
    public $timestamps = false; // Solo tiene created_at nullable o sin updated_at
    protected $fillable = ['product_id', 'image_path'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}