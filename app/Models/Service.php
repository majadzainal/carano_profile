<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'badge_id',
        'badge_en',
        'title_id',
        'title_en',
        'short_desc_id',
        'short_desc_en',
        'body_id',
        'body_en',
        'icon',
        'image_path',
        'features_id',
        'features_en',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'features_id' => 'array',
        'features_en' => 'array',
        'is_active' => 'boolean',
    ];

    public function localized(string $locale = 'id'): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'badge' => ($locale === 'en' && filled($this->badge_en)) ? $this->badge_en : $this->badge_id,
            'title' => ($locale === 'en' && filled($this->title_en)) ? $this->title_en : $this->title_id,
            'short_desc' => ($locale === 'en' && filled($this->short_desc_en)) ? $this->short_desc_en : $this->short_desc_id,
            'body' => ($locale === 'en' && filled($this->body_en)) ? $this->body_en : $this->body_id,
            'icon' => $this->icon,
            'image_path' => $this->image_path,
            'features' => ($locale === 'en' && !empty($this->features_en)) ? $this->features_en : ($this->features_id ?? []),
            'sort_order' => $this->sort_order,
        ];
    }
}
