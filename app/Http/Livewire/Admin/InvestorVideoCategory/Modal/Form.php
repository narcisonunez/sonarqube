<?php

namespace App\Http\Livewire\Admin\InvestorVideoCategory\Modal;

use App\Models\InvestorVideoCategory;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class Form extends ModalComponent
{
	
	public $investorVideoCategory;

	protected $rules = [
		'investorVideoCategory.name' => 'required',
	];

	public function mount($id = null ) {

		$this->investorVideoCategory = InvestorVideoCategory::firstOrNew(['id' => $id]);
	}

	public function render()
	{
		return view('livewire.admin.investor-video-category.modal.form');
	}

	public function save() {

		$this->validate();

		try {

			$this->investorVideoCategory->save();

			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.investorVideos.index'));
	}
}
