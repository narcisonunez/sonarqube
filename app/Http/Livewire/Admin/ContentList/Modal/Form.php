<?php

namespace App\Http\Livewire\Admin\ContentList\Modal;

use App\Models\ContentList;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Form extends ModalComponent
{
	use WithFileUploads;

	public $contentList;
	public $sectionId;
	public $featuredImage;

	protected $rules = [
		'contentList.title' => 'required',
		'contentList.subtitle' => '',
		'contentList.description' => '',
		'featuredImage' => 'nullable|image',
	];

	public function mount(int $sectionId, $id = null ) {

		$this->contentList = ContentList::firstOrNew(['id' => $id]);
		$this->sectionId = $sectionId;
	}

	public function render()
	{
		return view('livewire.admin.content-list.modal.form');
	}

	public function save() {

		$this->validate();

		try {

			$this->contentList->section_id = $this->sectionId;
			$this->contentList->save();

			if( !is_null($this->featuredImage) ){
				$this->contentList->addMedia($this->featuredImage->getRealPath())->toMediaCollection('featured_image');
			}

			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.sections.show', ['section' => $this->sectionId]));
	}
}
