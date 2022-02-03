<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Company extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;
    use SoftDeletes;

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
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('background_image')->singleFile();
        $this->addMediaCollection('founder_featured_image')->singleFile();
        $this->addMediaCollection('founder_secondary_image')->singleFile();
        $this->addMediaCollection('featured_video')->singleFile();
        $this->addMediaCollection('the_why_featured_video')->singleFile();
        $this->addMediaCollection('the_why_featured_image')->singleFile();
    }

    protected $guarded = [];

    public function episodes(): BelongsToMany
    {
        return $this->belongsToMany(Episode::class);
    }

    public function founders(): BelongsToMany
    {
        return $this->belongsToMany(Founder::class);
    }

    public function missionAuthor(): BelongsTo
    {
        return $this->belongsTo(Founder::class, 'mission_author_id');
    }

	public function values(): HasMany
	{
		return $this->hasMany(Value::class);
    }
}
