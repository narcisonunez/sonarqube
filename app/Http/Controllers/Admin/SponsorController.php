<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SponsorController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
	 */
	public function index()
	{
		$sponsors = Sponsor::all();
		return view('admin.sponsor.index', compact('sponsors'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
	 */
	public function create()
	{
		return view('admin.sponsor.create');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return view('admin.sponsor.edit', ['id' => $id]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Sponsor $sponsor
	 *
	 * @return Response
	 */
	public function destroy(Sponsor $sponsor)
	{
		try {

			$sponsor->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			Log::error('Location: SponsorController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.sponsors.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Sponsor $sponsor
	 *
	 * @return Response
	 */
	public function deactivate(Sponsor $sponsor)
	{
		try {

			$sponsor->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			Log::error('Location: SponsorController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.sponsors.index');
	}
}
