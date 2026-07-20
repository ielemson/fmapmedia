<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'vendor_type',
        'phone',
        'state',
        'city',
        'vendor_code',
        'referral_slug',
        'status',
        'commission_type',
        'commission_value',
        'total_earned',
        'total_paid',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'commission_value' => 'decimal:2',
        'total_earned' => 'decimal:2',
        'total_paid' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }
    public function clicks()
    {
        return $this->hasMany(VendorClick::class);
    }

    public function sales()
    {
        return $this->hasMany(VendorSale::class);
    }

    public function commissions()
    {
        return $this->hasMany(VendorCommission::class);
    }

    public function payouts()
    {
        return $this->hasMany(VendorPayout::class);
    }

    public function bankAccounts()
    {
        return $this->hasMany(VendorBankAccount::class);
    }

    public function defaultBankAccount()
    {
        return $this->hasOne(VendorBankAccount::class)->where('is_default', true);
    }

    public function orders()
{
    return $this->hasMany(Order::class);
}

public function withdrawals()
{
    return $this->hasMany(VendorWithdrawal::class);
}


public function supportTickets(): HasMany
{
    return $this->hasMany(SupportTicket::class);
}

public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    public function scopeSuspended(Builder $query): Builder
    {
        return $query->where('status', 'suspended');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function getAvailableBalanceAttribute(): float
    {
        return max(
            (float) $this->total_earned - (float) $this->total_paid,
            0
        );
    }
    
}
