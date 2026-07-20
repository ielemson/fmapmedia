<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorWithdrawal extends Model
{
    protected $fillable = [
        'vendor_id',
        'vendor_bank_account_id',
        'amount',
        'reference',
        'status',
        'remarks',
        'approved_at',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(VendorBankAccount::class, 'vendor_bank_account_id');
    }

    
}