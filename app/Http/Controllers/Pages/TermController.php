<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class TermController extends Controller
{
	public function index() {
		$sections = Section::getSectionsFromPage('terms');
		return view('pages.terms-of-use.index', compact('sections'));
	}
}
