<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class DisclosureController extends Controller
{
	public function index() {
		$sections = Section::getSectionsFromPage('disclosure');
		return view('pages.disclosure.index', compact('sections'));
	}
}
