<?php

namespace App\Http\Livewire\Admin\Section;

use App\Models\Section;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
	use WithFileUploads;

	public $section;
	public $backgroundImage;
	public $backgroundVideo;
	public $secondaryBackgroundImage;
	public $secondaryBackgroundVideo;
	public $logo;
	public $pageOptions;

	protected $rules = [
		'section.name' => 'required|max:255',
		'section.page' => 'required|max:255',
		'section.title' => 'required',
		'section.secondary_title' => 'nullable|max:255',
		'section.subtitle' => 'nullable',
		'section.secondary_subtitle' => 'nullable',
		'section.button_text' => 'max:255',
		'section.button_link' => 'nullable',
		'section.secondary_button_text' => 'nullable',
		'section.secondary_button_link' => 'nullable',
		'section.logo_text' => 'nullable',
		'backgroundImage' => 'nullable|image',
		'backgroundVideo' => 'nullable|mimes:mp4,mov,ogg,qt,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv',
        'secondaryBackgroundImage' => 'nullable|image',
        'secondaryBackgroundVideo' => 'nullable|mimes:mp4,mov,ogg,qt,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv',
		'section.description' => 'nullable',
		'section.meta_tags' => 'nullable',
	];

	public function mount($pageOptions, $id = null) {

		$this->section = Section::firstOrNew(['id' => $id]);
		$this->pageOptions = $pageOptions;

	}

	public function save() {

		$this->validate();
		try {
			$this->section->save();

			$this->addMedia();

			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.sections.index'));
	}

	private function addMedia() {

		$medias = [
			'logo' => 'logo',
			'backgroundImage' => 'background_image',
			'backgroundVideo' => 'background_video',
			'secondaryBackgroundImage' => 'secondary_background_image',
			'secondaryBackgroundVideo' => 'secondary_background_video',
		];

		foreach ( $medias as $mediaVar => $mediaCollection ) {
			if( !is_null($this->{$mediaVar}) ){
				$this->section->addMedia($this->{$mediaVar}->getRealPath())->toMediaCollection($mediaCollection);
			}
		}
	}
}
