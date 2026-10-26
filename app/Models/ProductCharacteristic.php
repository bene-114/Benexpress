<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCharacteristic extends Model
{
    use HasFactory;

    protected $table = 'product_characteristics';
    public $timestamps = false;
    protected $fillable = ['product_id', 'spec_text'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}