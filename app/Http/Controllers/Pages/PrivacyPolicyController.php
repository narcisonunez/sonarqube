<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
	public function index() {
		$sections = Section::getSectionsFromPage('privacy-policy');
		return view('pages.privacy-policy.index', compact('sections'));
	}
}
