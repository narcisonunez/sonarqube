<?php

namespace App\Models;

use App\Traits\HasSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Serie extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasSection;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $guarded = [];

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }

    public function trailers(): HasMany
    {
	    return $this->hasMany(Episode::class)->withAnyTags(['trailer'])->orderBy('id')->published();
    }

    public function latestEpisodes(): HasMany
    {
        return $this->episodes()
            ->latest('release_date')
            ->limit(5);
    }

    public function latestBehindTheScene(): HasMany
    {
        return $this->episodes()
            ->whereHas('tags', function($query) {
                $query->where('slug->en', 'behind-the-scenes');
            })
            ->latest('release_date')
            ->limit(5);
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
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
//    public function resolveRouteBinding($value, $field = null)
//    {
//        $query = $this->where($field ?? $this->getRouteKeyName(), $value);
//
//        if (Schema::hasColumn($this->getTable(), 'slug')) {
//            $query->orWhere('slug', $value);
//        }
//
//        return $query->first();
//    }
}
