<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Episode;
use App\Models\Host;
use App\Models\Season;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $series = request()->serieId;
    	$seasons = Season::select(['name', 'id'])
            ->where('serie_id', $series)
            ->get()
            ->pluck('name', 'id');
    	$hosts = Host::all()->pluck('name', 'id');
	    $companies = Company::all()->pluck('name', 'id');
	    $episodes = Episode::select(['name', 'id'])
            ->withAnyTags(['episode'])
            ->whereNull('parent_id')
            ->where('serie_id', $series)
            ->get()
            ->pluck('name', 'id');

	    return view('admin.episode.create', [
                                            'seasons' => $seasons,
                                            'hosts' => $hosts,
                                            'companies' => $companies,
                                            'episodes' => $episodes,
                                            'serieId' => $series]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
	    return view('admin.episode.show', [
		    'episode' => Episode::where('id', $id)->with('host', 'season', 'serie')->first(),
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $episode
     *
     * @return Response
     */
    public function edit($episode)
    {
        $series = request()->serieId;
        $seasons = Season::select(['name', 'id'])
            ->where('serie_id', $series)
            ->get()
            ->pluck('name', 'id');
        $hosts = Host::all()->pluck('name', 'id');
        $companies = Company::all()->pluck('name', 'id');
        $episodes = Episode::select(['name', 'id'])
            ->withAnyTags(['episode'])
            ->whereNull('parent_id')
            ->where('serie_id', $series)
            ->get()
            ->pluck('name', 'id');

	    return view('admin.episode.edit', ['id' => $episode,
	                                       'seasons' => $seasons,
	                                       'hosts' => $hosts,
	                                       'companies' => $companies,
	                                       'episodes' => $episodes,
	                                       'serieId' => $series,
                                        ]);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Episode $episode
	 *
	 * @return Response
	 */
	public function destroy(Episode $episode)
	{
		$serieId = $episode->serie_id;

		try {
			$episode->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( Exception $e) {
			Log::error('Location: EpisodeController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.series.show', ['series' => $serieId]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Episode $episode
	 *
	 * @return Response
	 */
	public function deactivate(Episode $episode)
	{
		$serieId = $episode->serie_id;

		try {

			$episode->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( Exception $e) {
			Log::error('Location: EpisodeController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.series.show', ['series' => $serieId]);
	}

	public function published(Episode $episode)
    {
        try {
            $episode->post();
            session()->flash('success', 'Action completed successfully.');
        } catch ( Exception $e) {
            Log::error('Location: EpisodeController published Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
        }

        return Redirect::route('admin.series.show', ['series' => $episode->serie_id]);
    }

    public function unpublished(Episode $episode)
    {
        try {
            $episode->dispost();
            session()->flash('success', 'Action completed successfully.');
        } catch ( Exception $e) {
            Log::error('Location: EpisodeController unPublished Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
        }

        return Redirect::route('admin.series.show', ['series' => $episode->serie_id]);
    }
}
