<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Episode;
use App\Models\InstagramPost;
use App\Models\Section;
use App\Models\Serie;
use App\Models\User;
use App\Services\InstagramGraph\InstagramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $background = ['', 'secondary_'];
        $rand = $background[rand(0, 1)];
	    $instagramPosts = InstagramPost::limit(9)->orderByDesc('timestamp')->get();

        $companies = Company::with('founders')->get();

	    $sections = Section::getSectionsFromPage('home');
	    $scenes = Episode::withAnyTags(['behind-the-scenes'])
            ->published()
		    ->latest('release_date')
            ->limit(5)
            ->get();

	    return view( 'pages.home.index', compact(
	    	'instagramPosts',
		    'companies',
		    'sections',
		    'scenes',
            'rand',
	    ) );
    }

	public function syncFeed( InstagramService $instagramService ) {
		$instagramService->refreshFeed();
		return redirect()->back();
    }

	public function validatePageControl() {

    	$hasAccess = Session::get('hasPageControl');

		if( $hasAccess ){
			return redirect(route('home'));

		}
		return view('auth.page-control');
    }

	public function registerPageControl(Request $request) {

		$request->validate([
			'password' => ['required'],
		]);

    	$users = User::where('email', '!=', 'support@createape.com')->get();

		foreach ( $users as $user ) {
			if (Auth::validate(['email' => $user->email, 'password' => $request->password ])) {
				Session::put('hasPageControl', true);
				break;
			}
    	}

		return redirect(route('home'));

    }
}
