<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'details',
        'summary',
        'image',
        'image_caption',
        'category_id',
        'status',
        'type',
        'featured',
        'breaking',
        'headline',
        'trending',
        'editors_pick',
        'view_count',
        'author_id',
        'old_id',
        'old_image',
        'source',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'breaking' => 'boolean',
        'headline' => 'boolean',
        'trending' => 'boolean',
        'editors_pick' => 'boolean',
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // public function getImageUrlAttribute()
    // {
    //     if (!$this->image) {
    //         return asset('backend/images/default-news.jpg');
    //     }

    //     return asset($this->image);
    // }

    public function getImageUrlAttribute()
{
    return $this->image
        ? asset('uploads/news/' . $this->image)
        : asset('backend/assets/images/default-news.jpg');
}
}