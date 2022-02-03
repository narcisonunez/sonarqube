<?php

namespace App\Traits;

use App\Models\Section;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasSection
{
    public function sections(): MorphToMany
    {
        return $this
            ->morphToMany(Section::class, 'sectionable');
    }
}
