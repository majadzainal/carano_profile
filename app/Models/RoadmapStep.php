<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoadmapStep extends Model
{
    protected $fillable = [
        'step_number',
        'phase',
        'title_id',
        'title_en',
        'description_id',
        'description_en',
        'highlights_id',
        'highlights_en',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'highlights_id' => 'array',
        'highlights_en' => 'array',
        'is_active' => 'boolean',
    ];

    public function localized(string $locale = 'id'): array
    {
        return [
            'id' => $this->id,
            'step_number' => $this->step_number,
            'phase' => $this->phase,
            'title' => ($locale === 'en' && filled($this->title_en)) ? $this->title_en : $this->title_id,
            'description' => ($locale === 'en' && filled($this->description_en)) ? $this->description_en : $this->description_id,
            'highlights' => ($locale === 'en' && !empty($this->highlights_en)) ? $this->highlights_en : ($this->highlights_id ?? []),
            'icon' => $this->icon,
        ];
    }
}
