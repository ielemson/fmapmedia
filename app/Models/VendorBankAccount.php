<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorBankAccount extends Model
{
    protected $fillable = [
        'vendor_id',
        'bank_name',
        'account_name',
        'account_number',
        'bank_code',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}