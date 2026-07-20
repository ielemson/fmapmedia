<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'user_id',
    'product_id',
    'vendor_id',
    'order_no',
    'qty',
    'unit_price',
    'subtotal',
    'discount',
    'total',
    'referral_slug',
    'commission_type',
    'commission_rate',
    'commission_amount',
    'payment_reference',
    'transaction_id',
    'payment_gateway',
    'gateway_reference',
    'charged_amount',
    'gateway_fee',
    'processor_response',
    'status',
    'payment_status',
    'competition_entry',
    'location',
    'meta',
    'paid_at',
];

protected $casts = [
    'meta' => 'array',
    'paid_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];

 public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
