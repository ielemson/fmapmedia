<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class GalleryAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'event_type',
        'event_date',
        'end_date',
        'venue',
        'location',
        'organizer',
        'excerpt',
        'report',
        'cover_image',
        'status',
        'is_featured',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'event_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (GalleryAlbum $album) {
            if (blank($album->slug)) {
                $album->slug = static::generateUniqueSlug($album->title);
            }
        });

        static::updating(function (GalleryAlbum $album) {
            if (blank($album->slug)) {
                $album->slug = static::generateUniqueSlug(
                    $album->title,
                    $album->id
                );
            }
        });
    }

    /**
     * Generate a unique album slug.
     */
    public static function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($title);
        $baseSlug = $baseSlug ?: 'gallery-album';

        $slug = $baseSlug;
        $counter = 1;

        while (
            static::query()
                ->when(
                    $ignoreId,
                    fn (Builder $query) => $query->whereKeyNot($ignoreId)
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * All photographs belonging to the album.
     */
    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Only visible photographs.
     */
    public function activeImages(): HasMany
    {
        return $this->hasMany(GalleryImage::class)
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Return only albums available to the public.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->where(function (Builder $query) {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Return featured albums.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Apply the standard display order.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->latest('event_date')
            ->latest('id');
    }

    /**
     * Use the slug for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}