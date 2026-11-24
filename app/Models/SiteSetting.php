<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'group',
        'label',
        'value_id',
        'value_en',
        'type',
        'sort_order',
    ];

    public static function allAsMap(string $locale = 'id'): array
    {
        $map = [];
        foreach (static::orderBy('sort_order')->get() as $setting) {
            $val = $locale === 'en' && filled($setting->value_en)
                ? $setting->value_en
                : $setting->value_id;
            $map[$setting->key] = $val;
        }
        return $map;
    }

    public static function getValue(string $key, string $locale = 'id', mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }
        return ($locale === 'en' && filled($setting->value_en))
            ? $setting->value_en
            : ($setting->value_id ?? $default);
    }
}
