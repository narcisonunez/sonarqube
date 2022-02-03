<?php

namespace App\Http\View\Composers;

use App\Models\Company;
use App\Models\Episode;
use App\Models\Section;
use App\Models\Serie;
use Illuminate\View\View;

class MultiComposer
{


	/**
	 * Bind data to the view.
	 *
	 * @param  \Illuminate\View\View  $view
	 * @return void
	 */
	public function compose(View $view)
	{
		$companies = Company::select('id','name', 'slug')->get();

		$series = Serie::where('slug', 'going-public')->get()->first();
		$trailersWithoutEpisodes = $series->trailers()->whereNull('parent_id')->get();
		$episodes = collect([]);
        $seenIn = Section::select('title', 'description')
            ->where('slug', 'as-seen-in')
            ->first();

		if( !($trailersWithoutEpisodes->count() >= 5) ){
			$episodes = Episode::withAnyTags(['episode'])
				->with([
				   'trailers' => function($query) {
				       $query->limit(5);
				   }
				])
				->latest('release_date')
				->published()
				->limit(5)
				->get();
		}

		$view->with('footerCompanies', $companies);
		$view->with('navEpisodes', $episodes);
		$view->with('navTrailersWithoutEpisodes', $trailersWithoutEpisodes);
		$view->with('seenIn', $seenIn);
	}
}
