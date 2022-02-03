<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Newsletter\NewsletterFacade as Newsletter;

class NewsletterController extends Controller
{
	public function subscribe(Request $request) {


		$validator = Validator::make( $request->all(), [ 'email' => 'required|email', ] );

		if ( $validator->fails() ) {
			return response()->json( [
				'error' => [
					'message' => $validator->errors()->first()
				]
			], 400 );
		}

		try {

			if ( ! Newsletter::isSubscribed($request->email) ) {
				Newsletter::subscribe( $request->email );

				return response()->json( [
					'success' => [
						'message' => 'Subscription sent successfully',
					]
				], 200 );
			}

			return response()->json( [
				'subscribed' => true,
			], 200 );

		} catch (\Exception $e) {
		    Log::error('Location: NewsletterController subscribe Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
			return response()->json( [
				'error' => [
					'message' => 'Internal error, try again.'
				]
			], 400 );
		}

		return redirect()->back();
    }
}
