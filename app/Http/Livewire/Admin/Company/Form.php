<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Company;
use App\Models\Founder;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
	use WithFileUploads;

	public $company;
	public $logo;
	public $backgroundImage;
	public $founderImage;
	public $founderSecImage;
	public $founderOptions;
	public $featuredVideo;
	public $theWhyFeaturedVideo;
	public $theWhyFeaturedImage;

	protected $rules = [
		'company.name' => 'required',
		'company.money_raised' => '',
		'company.price_per_share' => '',
		'company.min_investment' => '',
		'company.priority' => 'required|numeric',
		'company.valuation_cap' => '',
		'company.subtitle' => 'max:255',
		'company.hashtag' => 'max:255',
		'company.offering_circular_url' => 'max:255',
		'company.about_founders' => '',
		'company.more_about_founders' => '',
		'company.founders_video_url' => '',
		'company.mission' => '',
		'company.invest_url' => '',
		'company.more_about_mission' => '',
		'company.mission_video_url' => '',
		'company.mission_video_title' => '',
		'company.mission_video_description' => '',
		'company.mission_author_id' => 'nullable|exists:founders,id',
		'company.values_video_url' => '',
		'company.values_video_title' => '',
		'company.values_video_description' => '',
		'company.value_title_1' => '',
		'company.value_title_2' => '',
		'company.value_title_3' => '',
		'company.value_title_4' => '',
		'company.meta_tags' => '',
        'company.risk_summary_cta_copy' => 'nullable|max:255',
        'company.risk_summary_cta_link' => 'nullable|max:255',
        'company.risk_summary' => 'nullable',
        'company.reg_summary' => 'nullable',
		'logo' => 'nullable|image',
		'backgroundImage' => 'nullable|image',
		'founderImage' => 'nullable|image',
		'founderSecImage' => 'nullable|image',
		'featuredVideo' => 'nullable|mimes:mp4,mov,ogg,qt,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv',
		'theWhyFeaturedVideo' => 'nullable|mimes:mp4,mov,ogg,qt,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv',

	];

	public function mount($id = null) {

		$this->company = Company::firstOrNew(['id' => $id]);
		$this->founderOptions = Founder::all()->pluck('name', 'id');
	}

	public function save() {

		$this->validate();
		try {
			$this->company->save();

			$this->addMedia();

			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.company.index'));
	}

	private function addMedia() {

		$medias = [
			'logo' => 'logo',
			'backgroundImage' => 'background_image',
			'founderImage' => 'founder_featured_image',
			'founderSecImage' => 'founder_secondary_image',
			'featuredVideo' => 'featured_video',
			'theWhyFeaturedVideo' => 'the_why_featured_video',
			'theWhyFeaturedImage' => 'the_why_featured_image',
		];

		foreach ( $medias as $mediaVar => $mediaCollection ) {
			if( !is_null($this->{$mediaVar}) ){
				$this->company->addMedia($this->{$mediaVar}->getRealPath())->toMediaCollection($mediaCollection);
			}
		}
	}

}
