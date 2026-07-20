<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorSale extends Model
{
    protected $fillable = [
    'vendor_id',
    'order_id',
    'product_id',
    'user_id',
    'quantity',
    'sale_amount',
    'commission_rate',
    'commission_amount',
    'status',
    'confirmed_at',
    ];

    protected $casts = [
        'sale_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commission()
    {
        return $this->hasOne(VendorCommission::class);
    }
}