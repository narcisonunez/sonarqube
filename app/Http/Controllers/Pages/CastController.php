<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Section;
use Illuminate\Http\Request;

class CastController extends Controller
{
	public function index() {

		$casts = Cast::all();
		$sections = Section::getSectionsFromPage('casts');
		$page = 'cast';

		return view('pages.casts.index', compact('casts', 'sections', 'page'));
	}
}
