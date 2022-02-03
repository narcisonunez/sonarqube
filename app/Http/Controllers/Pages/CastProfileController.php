<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Section;
use App\Models\Serie;
use Illuminate\Http\Request;

class CastProfileController extends Controller
{
    public function index() {
		$episodes = Episode::whereHas('serie', function ($query) {
			$query->where('type', '!=', 'section');
			$query->where('type', '!=', 'behind-the-scenes');
		})->get();

		$sections = Section::getSectionsFromPage('episodes');
		$scenes = Serie::with('episodes')->where('type', 'section')->where('slug', 'behind-the-scenes')->first();

		return view('pages.cast-profile.index', compact('episodes', 'sections', 'scenes'));
	}
}
