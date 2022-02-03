<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Section;
use Illuminate\Http\Request;

class OfferingController extends Controller
{
    public function index() {
        $companies = Company::all();

    	$sections = Section::getSectionsFromPage('offering-circular');
	    return view('pages.offering.index', compact('sections', 'companies'));
    }
}
