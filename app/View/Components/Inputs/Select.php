<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Select extends Component
{
	public $name;
	public $options;

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($name, $options)
	{
		$this->name = $name;
		$this->options = $options;
	}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inputs.select');
    }
}
