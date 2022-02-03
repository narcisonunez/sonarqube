<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use TANIOS\Airtable\Airtable;

class ApplyController extends Controller
{
	public function index() {
		$sections = Section::getSectionsFromPage('apply');
		return view('pages.apply.index', compact('sections'));
	}

	public function saveCompanyApplication( Request $request ) {

		$currentime = Carbon::now();
		$currentLATime = $currentime->setTimezone(new CarbonTimeZone('America/Los_Angeles'))->format('Y-m-d H:i:s');

		$rules = [
			'email' => 'required|email',
			'firstname' => 'required',
			'lastname' => 'required',
			'presentation' => 'nullable|file|mimes:pptx,pps,ppsx,pdf',
		];

		$validator = Validator::make( $request->all(), $rules );

		if ( $validator->fails() ) {
			return response()->json( [
				'error' => [
					'message' => $validator->errors()->first()
				]
			], 400 );
		}

		try {

			$presentationUrl = '';

			if( $request->has('presentation') ){
				$filename = uniqid() . '.' . $request->file('presentation')->extension();

				$request->file('presentation')->storeAs('presentations', $filename, 's3');
				$filePath = 'presentations/'.$filename;
				if (Storage::disk('s3')->exists($filePath)) {
					$presentationUrl = Storage::disk('s3')->url($filePath);
				}
			}

			$airtable = new Airtable( [
					'api_key' => config('airtable.api_key'),
					'base'    => config('airtable.base_id'),
				]
			);

			$companyApplication = [
				"Founder's Email"      => $request->email,
				"Company's Name" => $request->company,
				"Founder's First Name" => $request->firstname,
				"Founders Last Name"   => $request->lastname,
				"Company Presentation" => [
					[
						"url" => $presentationUrl
					]
					],
				"Sent Time" => $currentLATime,
			];

			$response = $airtable->saveContent( config('airtable.table_name'), $companyApplication );

			if( !is_null($response->error) ){
				return response()->json( [
					'error' => [
						'message' => 'An error has ocurred, try again.'
					]
				], 400 );
			}

			return response()->json( [
				'success' => [
					'message' => 'Application sent successfully!'
				]
			], 200 );

		} catch (\Exception $e) {
		    Log::error('Location: ApplyController saveCompanyApplication M Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
			return response()->json( [
				'error' => [
					'message' => 'Internal error, try again.'
				]
			], 400 );
		}

	}
}
