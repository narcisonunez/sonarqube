<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Label extends Component
{
	public $for;
	public $value;

	/**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($for, $value)
    {
	    $this->for = $for;
	    $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.label');
    }
}
