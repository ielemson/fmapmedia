<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorClick extends Model
{
    protected $fillable = [
        'vendor_id',
        'product_id',
        'referral_slug',
        'ip_address',
        'user_agent',
        'browser',
        'device',
        'platform',
        'country',
        'referer',
        'clicked_at',
    ];

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}