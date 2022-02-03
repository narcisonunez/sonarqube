<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class FaqController extends Controller
{
	public function index() {
		$sections = Section::getSectionsFromPage('faq');
		return view('pages.faq.index', compact('sections'));
	}
}
