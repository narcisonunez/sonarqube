<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Episode;
use App\Models\Section;
use App\Models\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Serie::where('slug', 'going-public')->get()->first();
        $series->load([
            'seasons',
            'sections',
            'episodes' => function($query) {
                $query->with('season')->withAnyTags(['episode'])
                    ->published()
                    ->orderBy('id', 'ASC');
            },
            'trailers' => function($query) {
                $query->with('season');
            },
            'latestBehindTheScene' => function($query) {
                $query->published();
            },
        ]);

		//$trailersWithoutEpisodes = $series->trailers()->whereNull('parent_id')->get();

        $sections = $series->sections->last();

        return view('pages.series.index', compact('sections', 'series'));
    }
}
