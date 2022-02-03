<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
	    $series = Serie::all();
	    return view('admin.serie.index', compact('series'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
	    $typeOptions = ["television" => "Television", "web series" => "Web Series", "section" => "Section", "behind-the-scenes" => "Behind The Scenes"];
	    return view('admin.serie.create', compact('typeOptions'));
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 *
	 * @return Response
	 */
    public function show($id)
    {

	    return view('admin.serie.show', [
		    'serie' => Serie::where('id', $id)->with('episodes', 'seasons')->first(),
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
	    $typeOptions = ["television" => "Television", "web series" => "Web Series", "section" => "Section", "behind-the-scenes" => "Behind The Scenes"];
	    return view('admin.serie.edit', ['id' => $id, 'typeOptions' => $typeOptions]);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Serie $series
	 *
	 * @return Response
	 */
	public function destroy(Serie $series)
	{
		try {

			$series->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( \Exception $e) {
			Log::error('Location: SerieController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.series.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Serie $series
	 *
	 * @return Response
	 */
	public function deactivate(Serie $series)
	{
		try {

			$series->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( \Exception $e) {
			Log::error('Location: SerieController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.series.index');
	}
}
