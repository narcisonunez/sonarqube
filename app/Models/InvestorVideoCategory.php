<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class InvestorVideoCategory extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $guarded = [];

	/**
	 * Get the options for generating the slug.
	 */
	public function getSlugOptions() : SlugOptions
	{
		return SlugOptions::create()
		                  ->generateSlugsFrom('name')
		                  ->saveSlugsTo('slug');
	}

    public function investorVideos()
    {
        return $this->hasMany(InvestorVideo::class, 'investor_video_category_id');
    }
}
