<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Host;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class HostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
	    $hosts = Host::all();
	    return view('admin.host.index', compact('hosts'));    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
	    return view('admin.host.create');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $host
	 *
	 * @return Response
	 */
    public function edit($host)
    {
	    return view('admin.host.edit', ['id' => $host]);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Host $host
	 *
	 * @return Response
	 */
	public function destroy(Host $host)
	{
		try {

			$host->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			Log::error('Location: HostController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.hosts.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Host $host
	 *
	 * @return Response
	 */
	public function deactivate(Host $host)
	{
		try {

			$host->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			Log::error('Location: HostController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.hosts.index');
	}
}
