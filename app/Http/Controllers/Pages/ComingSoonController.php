<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComingSoonController extends Controller
{
    public function index() {
	    return response()
		    ->view('pages.coming-soon.index')
		    ->header('Retry-After', 'Sat, 30 Oct 2021 00:00:00 GMT');
    }
}
