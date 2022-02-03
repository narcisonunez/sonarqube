<?php

namespace App\Http\Livewire\Admin\Value\Modal;

use App\Models\Value;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class Form extends ModalComponent
{
	public $value;
	public $companyId;

	protected $rules = [
		'value.title' => 'required',
		'value.description' => 'required',
	];

	public function mount(int $companyId, $id = null ) {

		$this->value = Value::firstOrNew(['id' => $id]);
		$this->companyId = $companyId;
	}

	public function render()
	{
		return view('livewire.admin.value.modal.form');
	}

	public function save() {

		$this->validate();

		try {

			$this->value->company_id = $this->companyId;
			$this->value->save();

			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.company.show', ['company' => $this->companyId]));
	}
}
