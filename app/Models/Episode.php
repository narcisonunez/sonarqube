<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Episode extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasTags;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(Host::class);
    }

	public function companies(): BelongsToMany
	{
		return $this->belongsToMany(Company::class);
	}

	public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id')
            ->where('id', '!=', $this->id);
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id')
            ->where('id', '!=', $this->id);
    }

    public function trailers(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id')->withAnyTags(['trailer'])
            ->where('id', '!=', $this->id)->latest('release_date')->published();
    }

    public function siblings() {
        return $this->hasMany(static::class, 'parent_id', 'id')
        ->published()->where('id', '!=', $this->id);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')->singleFile();
        $this->addMediaCollection('featured_video_image')->singleFile();
    }

    public function scopePublished(Builder $query)
    {
        $query->where('is_published', true);
    }

    public function post()
    {
        $this->is_published = true;
        $this->published_at = now();

        $this->save();
    }

    public function dispost()
    {
        $this->is_published = false;
        $this->published_at = null;

        $this->save();
    }
}
