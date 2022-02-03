<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class SelectMultiple extends Component
{
	public $name;
	public $options;
	public $selections;

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($name, $options, $selections)
	{
		$this->name = $name;
		$this->options = $options;
		$this->selections = $selections;
	}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inputs.select-multiple');
    }
}
