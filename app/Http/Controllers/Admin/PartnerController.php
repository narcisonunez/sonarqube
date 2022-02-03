<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class PartnerController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
	 */
	public function index()
	{
		$partners = Partner::all();
		return view('admin.partner.index', compact('partners'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
	 */
	public function create()
	{
		return view('admin.partner.create');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return view('admin.partner.edit', ['id' => $id]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Partner $partner
	 *
	 * @return Response
	 */
	public function destroy(Partner $partner)
	{
		try {

			$partner->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			Log::error('Location: PartnerController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.partners.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Partner $partner
	 *
	 * @return Response
	 */
	public function deactivate(Partner $partner)
	{
		try {

			$partner->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			Log::error('Location: PartnerController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.partners.index');
	}
}
