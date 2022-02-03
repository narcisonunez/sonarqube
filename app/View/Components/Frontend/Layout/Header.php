<?php

namespace App\View\Components\Frontend\Layout;

use App\Helpers\Template;
use App\Models\Company;
use App\Models\Episode;
use App\Models\Section;
use App\Models\Serie;
use Illuminate\View\Component;

class Header extends Component
{
    public $headerSection;
    public $links;
    public $navEpisodes;
    public $navTrailersWithoutEpisodes;
    /**
     * Create a new component instance.
     *
     * @return void
     * @throws \Symfony\Component\Debug\Exception\FatalThrowableError
     */
    public function __construct()
    {
        $path = explode('/', request()->path());
        $page = $path[0];
        $this->headerSection = Section::select('title', 'description')
            ->where('slug', 'global-header')
            ->first();

        $nav = Section::select('description')
            ->where(function ($query) use ($page){
                $query->where('slug', 'LIKE', '%header-navigation-action%')
                    ->where('page', $page);
            })
            ->orWhere('slug', 'header-navigation-action')
            ->get();

        if ($nav->count() > 0) {
            $company = ($page === 'company') ? Company::where('slug', $path[1])->first() : [];
            $this->links = Template::eval( ($nav->count() > 1) ? $nav->last()->description : $nav->first()->description, compact('company'));
        }

        $episodesInfo = $this->getEpisodesInfoForNav();
        $this->navEpisodes = $episodesInfo[0];
        $this->navTrailersWithoutEpisodes = $episodesInfo[1];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     * @throws \Symfony\Component\Debug\Exception\FatalThrowableError
     */
    public function render()
    {
        return view('components.frontend.layout.header');
    }

	private function getEpisodesInfoForNav() {

		$series = Serie::where('slug', 'going-public')->get()->first();
		$trailersWithoutEpisodes = $series->trailers()->whereNull('parent_id')->get();
		$episodes = collect([]);

		if( !($trailersWithoutEpisodes->count() >= 5) ){
			$episodes = Episode::withAnyTags(['episode'])
               ->with([
                   'trailers' => function($query) {
	                   $query->limit(5);
                   }
               ])
               ->latest('release_date')
               ->published()
               ->limit(5)
               ->get();
		}

		return [$episodes, $trailersWithoutEpisodes];

	}
}
