<?php

namespace App\Http\Livewire\Admin\InvestorVideo;

use App\Models\InvestorVideo;
use App\Models\InvestorVideoCategory;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
	use WithFileUploads;

	public $investorVideo;
	public $featuredImage;
	public $categoryOptions;

	protected $rules = [
		'investorVideo.investor_video_category_id' => 'required|exists:investor_video_categories,id',
		'investorVideo.name' => 'required',
		'investorVideo.video_link' => 'required',
		'investorVideo.description' => '',
		'investorVideo.meta_title' => 'max:255',
		'investorVideo.meta_description' => 'max:255',
		'featuredImage' => 'nullable|image',
	];

	public function mount($id = null) {

		$this->investorVideo = InvestorVideo::firstOrNew(['id' => $id]);
		$this->categoryOptions = InvestorVideoCategory::all()->pluck('name', 'id');
	}

	public function save() {

		$this->validate();

		try {

			$this->investorVideo->save();

			if( !is_null($this->featuredImage) ){
				$this->investorVideo->addMedia($this->featuredImage->getRealPath())->toMediaCollection('featured_image');
			}
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.investorVideos.index'));
	}
}
