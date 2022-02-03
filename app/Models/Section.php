<?php

namespace App\Models;

use App\Helpers\Template;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Section extends Model implements HasMedia
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
		$this->addMediaCollection('background_image')->singleFile();
		$this->addMediaCollection('background_video')->singleFile();
		$this->addMediaCollection('logo')->singleFile();
	}

	protected $guarded = [];

	public static function getSectionsFromPage( string $page ): Collection {

		$sectionCollection = collect();

		try {

			$sections = self::where('page', $page)->get();
			$sharedSections = self::where('page', 'all')->get();
			$sectionCollection = $sections->merge($sharedSections)->mapWithKeys(function ($item, $key){
				return [$item->slug => $item];
			});

		} catch ( Exception $e) {
		    Log::error('Location: getSectionsFromPage Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return $sectionCollection;

	}

    /**
     * @throws \Symfony\Component\Debug\Exception\FatalThrowableError
     */
    public function getBladeDescriptionAttribute() {
        return Template::eval($this->attributes['description']);
    }

	public function contentLists(): HasMany
	{
		return $this->hasMany(ContentList::class);
	}

}
