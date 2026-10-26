<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_code', 'user_id', 'vendor_profile_id', 'delivery_type',
        'delivery_address', 'delivery_reference', 'delivery_phone',
        'delivery_cost', 'subtotal', 'total', 'payment_method', 'status', 'notes',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor() {
        return $this->belongsTo(VendorProfile::class, 'vendor_profile_id');
    }

    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}