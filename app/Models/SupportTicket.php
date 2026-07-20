<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    protected $fillable = [
        'vendor_id',
        'user_id',
        'assigned_to',
        'ticket_number',
        'subject',
        'category',
        'priority',
        'status',
        'message',
        'attachment',
        'last_reply_at',
        'resolved_at',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'last_reply_at' => 'datetime',
            'resolved_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(SupportTicketReply::class)
            ->oldest();
    }

    public function publicReplies(): HasMany
    {
        return $this->hasMany(SupportTicketReply::class)
            ->where('is_internal_note', false)
            ->oldest();
    }

    public function latestReply()
    {
        return $this->hasOne(SupportTicketReply::class)->latestOfMany();
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereNotIn('status', [
            'resolved',
            'closed',
        ]);
    }

    public function scopeForVendor(
        Builder $query,
        int $vendorId
    ): Builder {
        return $query->where('vendor_id', $vendorId);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open' => 'Open',
            'in_progress' => 'In Progress',
            'waiting_vendor' => 'Waiting for Vendor',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'open' => 'bg-primary',
            'in_progress' => 'bg-warning text-dark',
            'waiting_vendor' => 'bg-info text-dark',
            'resolved' => 'bg-success',
            'closed' => 'bg-secondary',
            default => 'bg-secondary',
        };
    }

    public function getPriorityClassAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'bg-secondary',
            'medium' => 'bg-info text-dark',
            'high' => 'bg-warning text-dark',
            'urgent' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}