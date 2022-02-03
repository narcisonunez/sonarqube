<?php

namespace App\Http\Livewire\Admin\Partner;

use App\Models\Partner;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
	use WithFileUploads;

	public $partner;
	public $logo;
	public $featuredImage;
	public $featuredVideo;

	protected $rules = [
		'partner.name' => 'required',
		'partner.description' => 'required',
		'partner.video_link' => '',
		'partner.external_link' => '',
		'logo' => 'nullable|image',
		'featuredImage' => 'nullable|image',
		'featuredVideo' => 'nullable|mimes:mp4,mov,ogg,qt,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv',
	];

	public function mount($id = null) {
		$this->partner = Partner::firstOrNew(['id' => $id]);
	}

	public function save() {

		$this->validate();

		try {

			$this->partner->save();

			$this->addMedia();

			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.partners.index'));
	}

	private function addMedia() {

		$medias = [
			'logo' => 'logo',
			'featuredImage' => 'featured_image',
			'featuredVideo' => 'featured_video',
		];

		foreach ( $medias as $mediaVar => $mediaCollection ) {
			if( !is_null($this->{$mediaVar}) ){
				$this->partner->addMedia($this->{$mediaVar}->getRealPath())->toMediaCollection($mediaCollection);
			}
		}
	}
}
