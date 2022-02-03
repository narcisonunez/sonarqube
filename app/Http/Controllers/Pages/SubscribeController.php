<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function index() {

    	$sections = Section::getSectionsFromPage('subscribe');
	    return view('pages.subscribe.index', compact('sections'));
    }
}
