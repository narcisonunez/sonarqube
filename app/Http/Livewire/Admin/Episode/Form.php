<?php

namespace App\Http\Livewire\Admin\Episode;

use App\Models\Episode;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
	use WithFileUploads;

	public $episode;
	public $serieId;
	public $companyIds = [];
	public $tags;
	public $seasonOptions;
    public $episodeOptions;
	public $hostOptions;
	public $companyOptions;
	public $companySelections;
	public $featuredImage;
	public $videoImage;

	protected $rules = [
		'companyIds' => 'nullable|array',
		'companyIds.*' => 'exists:companies,id',
		'episode.season_id' => 'required|numeric|exists:seasons,id',
        'episode.parent_id' => 'nullable',
		'episode.host_id' => 'numeric|exists:hosts,id',
		'episode.name' => 'required',
		'episode.title' => 'nullable|max:255',
        'tags' => 'nullable',
		'episode.duration' => 'numeric',
		'episode.release_date' => 'date',
		'episode.video_link' => 'nullable',
		'episode.render_id' => 'nullable|max:255',
		'episode.description' => 'nullable',
		'episode.meta_title' => 'max:255',
		'episode.meta_description' => 'max:255',
        'episode.meta_tags' => 'nullable',
        'episode.connatix_player' => 'nullable',
		'featuredImage' => 'nullable|image',
		'videoImage' => 'nullable|image',
	];

	public function mount($seasonOptions, $episodeOptions, $hostOptions, $companyOptions, int $serieId, $id = null) {
		$episode = Episode::firstOrNew(['id' => $id]);

		$episode->load('companies');
		$this->companySelections = $episode->companies->pluck('id')->toArray();

		$this->episode = $episode;
		$this->serieId = $serieId;
		$this->seasonOptions = $seasonOptions;
		$this->episodeOptions = $episodeOptions;
		$this->hostOptions = $hostOptions;
		$this->companyOptions = $companyOptions;
	}

	public function save() {

		$this->validate();

		try {

			if( !$this->episode->exists ){
				$this->episode->serie_id = $this->serieId;
			}

			$this->episode->save();

			$this->episode->companies()->sync($this->companyIds);

            if ( ! empty($this->tags) ) {
                //adding a single tag
                $this->episode->attachTag($this->tags);
            }

			if( !is_null($this->featuredImage) ){
				$this->episode->addMedia($this->featuredImage->getRealPath())->toMediaCollection('featured_image');
			}

			if( !is_null($this->videoImage) ){
				$this->episode->addMedia($this->videoImage->getRealPath())->toMediaCollection('featured_video_image');
			}

			session()->flash('success', 'Action completed successfully.');

		} catch (\Exception $e) {
			session()->flash('error', 'Internal Server Error');
			Log::error('Location: Livewire Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}

		return redirect()->to(route('admin.series.show', ['series' => $this->serieId]));
	}
}
