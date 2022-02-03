<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class CastController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
	 */
	public function index()
	{
		$casts = Cast::all();
		return view('admin.cast.index', compact('casts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
	 */
	public function create()
	{
		return view('admin.cast.create');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return view('admin.cast.edit', ['id' => $id]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Cast $cast
	 *
	 * @return Response
	 */
	public function destroy(Cast $cast)
	{
		try {

			$cast->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			Log::error('Location: CastController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.casts.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Cast $cast
	 *
	 * @return Response
	 */
	public function deactivate(Cast $cast)
	{
		try {

			$cast->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			Log::error('Location: CastController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.casts.index');
	}
}
