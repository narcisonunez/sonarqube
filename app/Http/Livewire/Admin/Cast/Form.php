<?php

namespace App\Http\Livewire\Admin\Cast;

use App\Models\Cast;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
	use WithFileUploads;

	public $cast;
	public $logo;
	public $featuredImage;
	public $featuredVideo;
	public $typesOption;

	protected $rules = [
		'cast.type' => 'required',
		'cast.name' => 'required',
		'cast.description' => 'required',
		'cast.video_link' => '',
		'cast.external_link' => '',
		'featuredImage' => 'nullable|image',
		'featuredVideo' => 'nullable|mimes:mp4,mov,ogg,qt,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv',
	];

	public function mount($id = null) {
		$this->cast = Cast::firstOrNew(['id' => $id]);
		$this->typesOption = ['host' => 'The Host', 'mentor' => 'The Mentors', 'billionaire' => 'The Billionaire', 'banker' => 'The Banker'];
	}

	public function save() {

		$this->validate();

		try {

			$this->cast->save();

			$this->addMedia();

			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.casts.index'));
	}

	private function addMedia() {

		$medias = [
			'featuredImage' => 'featured_image',
			'featuredVideo' => 'featured_video',
		];

		foreach ( $medias as $mediaVar => $mediaCollection ) {
			if( !is_null($this->{$mediaVar}) ){
				$this->cast->addMedia($this->{$mediaVar}->getRealPath())->toMediaCollection($mediaCollection);
			}
		}
	}
}
