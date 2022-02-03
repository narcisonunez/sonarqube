<?php

namespace App\Http\Livewire\Admin\Press;

use App\Models\Press;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
	use WithFileUploads;

	public $press;
	public $featuredImage;
	public $authorPicture;
	public $categoryOptions;
	public $booleanOptions;

	protected $rules = [
		'press.category_id' => 'nullable|exists:categories,id',
		'press.title' => 'required',
		'press.author' => 'required',
		'press.description' => 'max:255',
		'press.published_at' => 'required|date',
		'press.url' => 'max:255',
		'press.content' => '',
		'press.meta_tags' => '',
		'press.is_featured' => 'boolean',
		'featuredImage' => 'nullable|image',
		'authorPicture' => 'nullable|image',
	];

	public function mount($categories, $id = null) {

		$this->press = Press::firstOrNew(['id' => $id]);
		$this->categoryOptions = $categories;
		$this->booleanOptions = ['No', 'Yes'];
	}

	public function save() {

		$this->validate();

		try {

			if( $this->press->is_featured ){
				Press::where('is_featured', 1)->update(['is_featured' => 0]);
			}

			$this->press->category_id = empty($this->press->category_id) ? null : $this->press->category_id;
			$this->press->save();

			if( !is_null($this->featuredImage) ){
				$this->press->addMedia($this->featuredImage->getRealPath())->toMediaCollection('featured_image');
			}

			if( !is_null($this->authorPicture) ){
				$this->press->addMedia($this->authorPicture->getRealPath())->toMediaCollection('author_picture');
			}

			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.presses.index'));
	}
}
