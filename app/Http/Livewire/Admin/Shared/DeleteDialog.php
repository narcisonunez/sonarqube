<?php

namespace App\Http\Livewire\Admin\Shared;

use LivewireUI\Modal\ModalComponent;

class DeleteDialog extends ModalComponent
{
	public $method;
	public $route;

	public function mount($method, $route) {
		$this->method = $method;
		$this->route = $route;
	}

    public function render()
    {
        return view('livewire.admin.shared.delete-dialog');
    }
}
