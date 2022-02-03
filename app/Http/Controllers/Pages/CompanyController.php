<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Episode;
use App\Models\InstagramPost;
use App\Models\Section;

class CompanyController extends Controller
{
	public function index($slug)
	{
		$company = Company::where('slug', $slug)->first();

		if( empty($company) ){
			abort(404);
		}

		$instagramPosts = InstagramPost::limit(9)
		                               ->where('caption','LIKE','%'.$company->hashtag.'%')
		                               ->orderByDesc('timestamp')->get();

		if( $instagramPosts->count() < 9 ){
			$recentPosts = InstagramPost::limit( (9 - $instagramPosts->count()) )
			                            ->where('caption','NOT LIKE','%'.$company->hashtag.'%')
			                            ->orderByDesc('timestamp')->get();

			$instagramPosts = $instagramPosts->concat($recentPosts->all());
		}

		$company->load(['missionAuthor', 'founders', 'values']);
        $scenes = Episode::withAnyTags(['behind-the-scenes'])
            ->whereHas('companies', function ( $query ) use ( $company ) {
                $query->where('company_id', $company->id );
            })
            ->published()
	        ->latest('release_date')
            ->limit(5)
            ->get();

		$sections = Section::getSectionsFromPage('company');
		$goingPublicHeroSection = Section::where('slug', 'going-public-hero')->first();
		$sections->put('going-public-hero', $goingPublicHeroSection);

		$companies = Company::all();

		return view( 'pages.company.index', compact(
			'company',
			'instagramPosts',
			'scenes',
			'sections',
			'companies',
		) );
	}

	public function getCompanies()
	{
		$sections = Section::getSectionsFromPage('companies');
		$companies = Company::all()->shuffle();

		return view('pages.companies.index', compact('companies', 'sections'));
	}
}
