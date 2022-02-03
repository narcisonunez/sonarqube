<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Season;

class EpisodeController extends Controller
{
	public function index(Season $season, Episode $episode)
	{
		$episode->load(['serie', 'serie.sections', 'siblings', 'tags']);
		$sections = $episode->serie->sections->last();
		$otherEpisodes = Episode::withAnyTags(['episode'])
			->where('id', '!=', $episode->id)
			->where('season_id', $season->id)
			->orderBy('release_date')
			->get();
		$siblings = $episode->siblings;

		if ($siblings->isEmpty() and $episode->parent_id != 0)
        {
            $siblings = Episode::where(function($query) use ($episode) {
                $query->where('id', $episode->parent_id)
                    ->orWhere('parent_id', $episode->parent_id);
            })->where('id', '!=', $episode->id)->published()->get();
        }

		return view('pages.episodes.index', compact('episode', 'sections', 'otherEpisodes', 'siblings'));
	}
}
