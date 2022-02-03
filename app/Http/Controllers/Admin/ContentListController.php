<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class ContentListController extends Controller

{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param ContentList $contentList
	 *
	 * @return Response
	 */
	public function destroy(ContentList $contentList)
	{

		try {

			$contentList->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( \Exception $e) {
			Log::error('Location: ContentListController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.sections.show', ['section' => request()->section]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param ContentList $contentList
	 *
	 * @return Response
	 */
	public function deactivate(ContentList $contentList)
	{
		try {

			$contentList->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( \Exception $e) {
			Log::error('Location: ContentListController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.sections.show', ['section' => request()->section]);
	}
}
