<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeHub extends Model
{
    protected $fillable = [
        'type',
        'code',
        'name_id',
        'name_en',
        'country',
        'description_id',
        'description_en',
        'map_x',
        'map_y',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'map_x' => 'float',
        'map_y' => 'float',
        'is_active' => 'boolean',
    ];

    public function localized(string $locale = 'id'): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'code' => $this->code,
            'name' => ($locale === 'en' && filled($this->name_en)) ? $this->name_en : $this->name_id,
            'country' => $this->country,
            'description' => ($locale === 'en' && filled($this->description_en)) ? $this->description_en : $this->description_id,
            'map_x' => $this->map_x,
            'map_y' => $this->map_y,
        ];
    }
}
