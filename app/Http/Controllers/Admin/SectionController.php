<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SectionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
	 */
	public function index()
	{
		$sections = Section::withTrashed()
            ->orderBy('page')
            ->get();
		$pages = [
			'all'       => 'All',
			'home'      => 'Home',
			'episodes'  => 'Episodes',
			'company'   => 'Company',
			'companies' => 'Companies',
			'apply'     => 'Apply',
			'press'     => 'Press',
			'post'      => 'Post',
			'investor-iq'  => 'Investor IQ',
			'sponsors'  => 'Sponsors',
			'partners'  => 'Partners',
			'casts'  => 'Casts',
			'subscribe'  => 'Subscribe',
			'terms'  => 'Terms',
			'privacy-policy'  => 'Privacy Policy',
			'faq'  => 'FAQ',
			'disclosure'  => 'Disclosure',
			'offering-circular'  => 'Offering Circular',
		];

		return view('admin.section.index', compact('sections', 'pages'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
	 */
	public function create()
	{
		$pages = [
			'all'       => 'All',
			'home'      => 'Home',
			'episodes'  => 'Episodes',
			'company'   => 'Company',
			'companies' => 'Companies',
			'apply'     => 'Apply',
			'press'     => 'Press',
			'post'      => 'Post',
			'investor-iq'  => 'Investor IQ',
			'sponsors'  => 'Sponsors',
			'partners'  => 'Partners',
			'casts'  => 'Casts',
			'subscribe'  => 'Subscribe',
			'terms'  => 'Terms',
			'privacy-policy'  => 'Privacy Policy',
			'faq'  => 'FAQ',
			'disclosure'  => 'Disclosure',
			'offering-circular'  => 'Offering Circular',
		];

		return view('admin.section.create', ['pages' => $pages]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $section
	 * @return Response
	 */
	public function show($section)
	{
		return view('admin.section.show', [
			'section' => Section::where('id', $section)->first(),
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
		$pages = [
			'all'       => 'All',
			'home'      => 'Home',
			'episodes'  => 'Episodes',
			'company'   => 'Company',
			'companies' => 'Companies',
			'apply'     => 'Apply',
			'press'     => 'Press',
			'post'      => 'Post',
			'investor-iq'  => 'Investor IQ',
			'sponsors'  => 'Sponsors',
			'partners'  => 'Partners',
			'casts'  => 'Casts',
			'subscribe'  => 'Subscribe',
			'terms'  => 'Terms',
			'privacy-policy'  => 'Privacy Policy',
			'faq'  => 'FAQ',
			'disclosure'  => 'Disclosure',
			'offering-circular'  => 'Offering Circular',
		];

		return view('admin.section.edit', ['pages' => $pages, 'id' => $id]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Section $section
	 *
	 * @return Response
	 */
	public function destroy(Section $section)
	{
		try {

			$section->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			Log::error('Location: SectionController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.sections.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Section $section
	 *
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function deactivate(Section $section)
	{
		try {

			$section->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			Log::error('Location: SectionController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.sections.index');
	}

    /**
     * Add the specified resource from storage.
     *
     * @param int $section
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(int $section)
    {
        try {
            $section = Section::withTrashed()->findOrFail($section);
            $section->update([
                'deleted_at' => null
            ]);
            session()->flash('success', 'Action completed successfully.');

        } catch (\Exception $e) {
            Log::error('Location: SectionController active Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
        }

        return Redirect::route('admin.sections.index');
    }
}
