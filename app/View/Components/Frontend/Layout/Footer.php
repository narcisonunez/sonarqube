<?php

namespace App\View\Components\Frontend\Layout;

use App\Helpers\Template;
use App\Models\Company;
use App\Models\Section;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Component;

class Footer extends Component
{
    public $footerCompanies;
    public $footerSection;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->footerCompanies = Company::select('id','name', 'slug')->get();
        $this->footerSection = Section::select('title', 'description')
            ->where('slug', 'global-footer')
            ->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return str_replace('&gt;', '>', Blade::compileString($this->footerSection->description));
    }
}
