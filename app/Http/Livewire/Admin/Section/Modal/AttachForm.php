<?php

namespace App\Http\Livewire\Admin\Section\Modal;

use App\Models\Section;
use App\Models\Serie;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class AttachForm extends ModalComponent
{
    public $series;
    public $sectionOptions;
    public $section;

    protected $rules = [
        'section.id' => 'required',
    ];

    public function mount(int $serieId)
    {
        $this->series = Serie::find($serieId);
        $this->sectionOptions = Section::all()
            ->pluck('name', 'id');
    }

    public function render()
    {
        return view('livewire.admin.section.modal.attach-form');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->series->sections()->attach($this->section['id']);
            session()->flash('success', 'Action completed successfully.');

        } catch (\Exception $e) {
            session()->flash('error', 'Internal Server Error');
            Log::error('Location: Livewire Attach Form save Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
        }

        return redirect()->to(route('admin.series.show', ['series' => $this->series->id]));
    }
}
