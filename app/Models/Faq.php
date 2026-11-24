<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question_id',
        'question_en',
        'answer_id',
        'answer_en',
        'category',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function localized(string $locale = 'id'): array
    {
        return [
            'id' => $this->id,
            'question' => ($locale === 'en' && filled($this->question_en)) ? $this->question_en : $this->question_id,
            'answer' => ($locale === 'en' && filled($this->answer_en)) ? $this->answer_en : $this->answer_id,
            'category' => $this->category,
        ];
    }
}
