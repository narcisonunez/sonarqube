<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestorVideoCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class InvestorVideoCategoryController extends Controller
{

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param InvestorVideoCategory $investorVideoCategory
	 *
	 * @return Response
	 */
	public function destroy(InvestorVideoCategory $investorVideoCategory)
	{

		try {

			$investorVideoCategory->forceDelete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( \Exception $e) {
			Log::error('Location: InvestorVideoCategoryController destroy Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.investorVideos.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param InvestorVideoCategory $investorVideoCategory
	 *
	 * @return Response
	 */
	public function deactivate(InvestorVideoCategory $investorVideoCategory)
	{
		try {

			$investorVideoCategory->delete();
			session()->flash('success', 'Action completed successfully.');

		} catch ( \Exception $e) {
			Log::error('Location: InvestorVideoCategoryController delete Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return Redirect::route('admin.investorVideos.index');
	}
}
