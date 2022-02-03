<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index()
    {
    	$companies = Company::all();
        return view('admin.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function create()
    {
        return view('admin.company.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $company
     * @return Response
     */
    public function show($company)
    {
	    return view('admin.company.show', [
		    'company' => Company::where('id', $company)->with('founders')->first(),
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        return view('admin.company.edit', ['id' => $id]);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Company $company
	 *
	 * @return Response
	 */
    public function destroy(Company $company)
    {
        try {

        	$company->forceDelete();
	        session()->flash('success', 'Action completed successfully.');

        } catch (\Exception $e) {
            Log::error('Location: CompanyController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
        }

	    return Redirect::route('admin.company.index');
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Company $company
	 *
	 * @return Response
	 */
    public function deactivate(Company $company)
    {
        try {

        	$company->delete();
	        session()->flash('success', 'Action completed successfully.');

        } catch (\Exception $e) {
            Log::error('Location: CompanyController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
        }

	    return Redirect::route('admin.company.index');
    }
}
