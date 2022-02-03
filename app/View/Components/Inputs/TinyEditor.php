<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class TinyEditor extends Component
{
    public $name;
    public $xheight;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $xheight = 600)
    {
        $this->name = $name;
        $this->xheight = $xheight;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inputs.tiny-editor');
    }
}
