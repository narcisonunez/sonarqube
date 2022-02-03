<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Editor extends Component
{
	public $name;
	public $debounceTarget;

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($name, $debounceTarget)
	{
		$this->name = $name;
		$this->debounceTarget = $debounceTarget;
	}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inputs.editor');
    }
}
