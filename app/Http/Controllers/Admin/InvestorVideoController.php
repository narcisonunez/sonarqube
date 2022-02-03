<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestorVideo;
use App\Models\InvestorVideoCategory;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class InvestorVideoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Application|Factory|View|Response
	 */
	public function index()
	{
		$investorVideos = InvestorVideo::with('category')->get();
		$categories = InvestorVideoCategory::all();

		return view('admin.investorVideo.index', compact('investorVideos', 'categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Application|Factory|View|Response
	 */
	public function create()
	{
		return view('admin.investorVideo.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $investorVideo
	 * @return Response
	 */
	public function show($investorVideo)
	{
		return view('admin.investorVideo.show', [
			'investorVideo' => InvestorVideo::where('id', $investorVideo)->with('category')->first(),
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $investorVideo
	 * @return Response
	 */
	public function edit($investorVideo)
	{
		return view('admin.investorVideo.edit', ['investorVideo' => $investorVideo]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param InvestorVideo $investorVideo
	 *
	 * @return Response
	 */
	public function destroy(InvestorVideo $investorVideo)
	{
		try {

			$investorVideo->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( Exception $e) {
			Log::error('Location: InvestorVideoController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.investorVideos.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param InvestorVideo $investorVideo
	 *
	 * @return Response
	 */
	public function deactivate(InvestorVideo $investorVideo)
	{
		try {

			$investorVideo->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( Exception $e) {
			Log::error('Location: InvestorVideoController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.investorVideos.index');
	}
}
