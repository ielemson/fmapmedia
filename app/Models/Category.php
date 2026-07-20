<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_name',
        'slug',
        'description',
        'status',
    ];

    /**
     * Category Products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if category is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    

protected static function boot()
{
    parent::boot();

    static::creating(function ($category) {
        if (empty($category->slug)) {
            $category->slug = Str::slug($category->cat_name);
        }
    });

    static::updating(function ($category) {
        if ($category->isDirty('cat_name')) {
            $category->slug = Str::slug($category->cat_name);
        }
    });
}
}