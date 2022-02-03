<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Press;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class PressController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Application|Factory|View|Response
	 */
	public function index()
	{
		$presses = Press::all();
		return view('admin.press.index', compact('presses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Application|Factory|View|Response
	 */
	public function create()
	{
		$categories = Category::all()->pluck('name', 'id');

		return view('admin.press.create', compact('categories'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $press
	 * @return Response
	 */
	public function show($press)
	{
		return view('admin.press.show', [
			'press' => Press::where('id', $press)->with('category')->first(),
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $press
	 * @return Response
	 */
	public function edit($press)
	{
		$categories = Category::all()->pluck('name', 'id');

		return view('admin.press.edit', ['categories' => $categories, 'press' => $press]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Press $press
	 *
	 * @return Response
	 */
	public function destroy(Press $press)
	{
		try {

			$press->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( Exception $e) {
			Log::error('Location: PressController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.presses.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Press $press
	 *
	 * @return Response
	 */
	public function deactivate(Press $press)
	{
		try {

			$press->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( Exception $e) {
			Log::error('Location: PressController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.presses.index');
	}
}
