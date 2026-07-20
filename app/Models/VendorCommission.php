<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorCommission extends Model
{
    protected $fillable = [
        'vendor_id',
        'vendor_sale_id',
        'amount',
        'rate',
        'status',
        'approved_at',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'rate' => 'decimal:2',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function sale()
    {
        return $this->belongsTo(VendorSale::class, 'vendor_sale_id');
    }
}