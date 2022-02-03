<?php

namespace App\Http\Livewire\Admin\Season\Modal;

use App\Models\Season;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Form extends ModalComponent
{
	public $season;
	public $serieId;

	protected $rules = [
		'season.name' => 'required',
		'season.description' => 'max:255',
	];

	public function mount(int $serieId, $id = null ) {

		$this->season = Season::firstOrNew(['id' => $id]);
		$this->serieId = $serieId;
	}

	public function render()
	{
		return view('livewire.admin.season.modal.form');
	}

	public function save() {

		$this->validate();

		try {

			if( !$this->season->exists ){
				$this->season->serie_id = $this->serieId;
			}

			$this->season->save();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.series.show', ['series' => $this->serieId]));
	}
}
