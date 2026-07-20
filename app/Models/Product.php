<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

  protected $fillable = [
    'category_id',
    'name',
    'slug',
    'image',
    'file',
    'price',
    'published_at',
    'desc',
    'status',
    'competition_status',

    // Vendor Commission Settings
    'commission_type',
    'commission_value',
    'commission_target_qty',
];
    protected $casts = [
        'published_at' => 'date',
        'price' => 'decimal:2',
    ];

    /**
     * Product Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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

    /**
     * Scope for published products
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for draft products
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope for archived products
     */
    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    /**
     * Check if product is published
     */
    public function isPublished()
    {
        return $this->status === 'published';
    }

public function orders()
{
    return $this->hasMany(Order::class);
}

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}
