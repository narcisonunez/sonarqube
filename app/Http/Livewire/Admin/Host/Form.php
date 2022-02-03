<?php

namespace App\Http\Livewire\Admin\Host;

use App\Models\Host;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Form extends Component
{
	public $host;

	protected $rules = [
		'host.name' => 'required',
		'host.about' => 'max:255',
	];

	public function mount($id = null) {

		$this->host = Host::firstOrNew(['id' => $id]);
	}

	public function save() {

		$this->validate();

		try {
			$this->host->save();
			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.hosts.index'));
	}
}
