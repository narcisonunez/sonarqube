<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
	public function index() {
		$partners = Partner::all();
		$sections = Section::getSectionsFromPage('partners');
		$page = 'partner';

		return view('pages.partners.index', compact('partners', 'sections', 'page'));
	}
}
