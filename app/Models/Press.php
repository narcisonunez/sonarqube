<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Press extends Model implements HasMedia
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
		                  ->generateSlugsFrom('title')
		                  ->saveSlugsTo('slug');
	}

	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('featured_image')->singleFile();
		$this->addMediaCollection('author_picture')->singleFile();
	}

	protected $guarded = [];

	public function getPublishedDateForHumansAttribute() {
		return Carbon::parse($this->published_at)->toFormattedDateString();
	}
	
	public function category() {
		return $this->belongsTo(Category::class);
	}
}
