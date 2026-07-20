<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsCategory extends Model
{
    use HasFactory;

    protected $table = 'news_categories';

    protected $fillable = [
        'name',
        'slug',
        'status',
        'description',
        'image',
        'icon',
        'sort_order',
        'show_on_menu',
        'show_on_homepage',
    ];

    protected $casts = [
        'show_on_menu' => 'boolean',
        'show_on_homepage' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function news()
    {
        return $this->hasMany(
            News::class,
            'category_id',
            'id'
        );
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('backend/images/default-category.jpg');
        }

        return asset($this->image);
    }
    
}