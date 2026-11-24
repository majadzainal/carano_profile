<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = [
        'page_slug',
        'section_key',
        'section_label',
        'badge_id',
        'badge_en',
        'title_id',
        'title_en',
        'subtitle_id',
        'subtitle_en',
        'body_id',
        'body_en',
        'cta_label_id',
        'cta_label_en',
        'cta_url',
        'secondary_cta_label_id',
        'secondary_cta_label_en',
        'secondary_cta_url',
        'image_path',
        'extra_json',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'extra_json' => 'array',
        'is_active' => 'boolean',
    ];

    public function localized(string $locale = 'id'): array
    {
        $pick = fn (string $field) => ($locale === 'en' && filled($this->{$field . '_en'}))
            ? $this->{$field . '_en'}
            : $this->{$field . '_id'};

        return [
            'id' => $this->id,
            'page_slug' => $this->page_slug,
            'section_key' => $this->section_key,
            'section_label' => $this->section_label,
            'badge' => $pick('badge'),
            'title' => $pick('title'),
            'subtitle' => $pick('subtitle'),
            'body' => $pick('body'),
            'cta_label' => $pick('cta_label'),
            'cta_url' => $this->cta_url,
            'secondary_cta_label' => $pick('secondary_cta_label'),
            'secondary_cta_url' => $this->secondary_cta_url,
            'image_path' => $this->image_path,
            'extra' => $this->extra_json ?? [],
            'is_active' => $this->is_active,
        ];
    }
}
