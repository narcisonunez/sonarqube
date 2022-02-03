<?php

namespace App\Http\Livewire\Admin\Founder\Modal;

use App\Models\Founder;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Form extends ModalComponent
{
	use WithFileUploads;

	public $founder;
	public $companyId;
	public $profileImage;

	protected $rules = [
		'founder.name' => 'required',
		'founder.position' => 'required',
		'founder.about' => 'max:255',
	];

	public function mount(int $companyId, $id = null ) {

		$this->founder = Founder::firstOrNew([ 'id' => $id]);
		$this->companyId = $companyId;
	}

	public function render()
	{
		return view('livewire.admin.founder.modal.form');
	}

	public function save() {

		$this->validate();

		try {

			$founderDidntExists = false;

			if( !$this->founder->exists ){
				$founderDidntExists = true;
			}

			$this->founder->save();

			if( $founderDidntExists ){
				$this->founder->companies()->sync(['company_id' => $this->companyId]);
			}

			if( !is_null($this->profileImage) ){
				$this->founder->addMedia($this->profileImage->getRealPath())->toMediaCollection('profile');
			}

			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.company.show', ['company' => $this->companyId]));
	}
}
