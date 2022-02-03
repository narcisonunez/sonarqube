<?php

namespace App\Models;

use Illumina\te\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class ContentList extends Model implements HasMedia
{
	use HasFactory;
	use InteractsWithMedia;
	use SoftDeletes;

	protected $guarded = [];

	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('featured_image')->singleFile();
	}

	public function section(): BelongsTo {
		return $this->belongsTo(Section::class);
	}
}
