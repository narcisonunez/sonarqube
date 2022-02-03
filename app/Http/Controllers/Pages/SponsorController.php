<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
	public function index() {
		$sponsors = Sponsor::all();
		$sections = Section::getSectionsFromPage('sponsors');
		$page = 'sponsor';

		return view('pages.sponsors.index', compact('sponsors', 'sections', 'page'));
	}
}
