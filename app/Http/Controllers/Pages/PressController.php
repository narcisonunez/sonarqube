<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Press;
use App\Models\Section;
use Illuminate\Http\Request;

class PressController extends Controller
{
	public function index() {

		$sections = Section::getSectionsFromPage('press');
		$featuredPress = Press::with('category')->where('is_featured', 1)->first();
		$page = request()->has('page') ? request()->page : null;
		$presses = Press::with('category')->where('is_featured', 0)
		                                  ->orderBy('published_at', 'desc')->simplePaginate(6, '*', 'page', $page);

		return view('pages.press.index', compact('featuredPress', 'presses', 'sections'));
	}

	public function showPost( $slug ) {

		$press = Press::where('slug', $slug)->first();

		if( empty($press) || !empty($press->url) || (empty($press->url) && empty($press->content)) ){
			abort(404);
		}

		$latestPress = Press::where('id', '!=', $press->id)->orderByDesc('created_at')->limit(3)->get();

		return view('pages.post.index', compact( 'press', 'latestPress'));
	}
}
