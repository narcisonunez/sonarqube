<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\InvestorVideo;
use App\Models\InvestorVideoCategory;
use App\Models\Section;

class InvestorVideoController extends Controller {

	public function index() {
		$sections = Section::getSectionsFromPage('investor-iq');

		$vignettes = InvestorVideo::whereHas('category', function ($query){
			$query->where('slug', 'main');
		})->get();

		$investorVideoCategories = InvestorVideoCategory::with('investorVideos')
		                                                ->whereHas('investorVideos', function ($query){
															$query->limit(2);
														})->where('slug', '!=', 'main')->get();

		return view('pages.investor.index', compact('sections', 'vignettes', 'investorVideoCategories'));
	}
}
