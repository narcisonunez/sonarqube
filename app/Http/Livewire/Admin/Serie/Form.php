<?php

namespace App\Http\Livewire\Admin\Serie;

use App\Models\Serie;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Form extends Component
{
	public $serie;
	public $typeOptions;

	protected $rules = [
		'serie.name' => 'required',
		'serie.description' => 'max:255',
		'serie.tag_line' => 'max:255',
		'serie.type' => 'required',
		'serie.meta_title' => '',
		'serie.meta_description' => '',
	];

	public function mount($id = null, $typeOptions) {
		$this->typeOptions = $typeOptions;
		$this->serie = Serie::firstOrNew(['id' => $id]);
	}

	public function save() {

		$this->validate();
		try {
			$this->serie->save();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.series.index'));
	}

}
