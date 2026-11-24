<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'slug',
        'title_id',
        'title_en',
        'excerpt_id',
        'excerpt_en',
        'body_id',
        'body_en',
        'category',
        'featured_image',
        'meta_title',
        'meta_description',
        'status',
        'published_at',
        'author_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function localized(string $locale = 'id'): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => ($locale === 'en' && filled($this->title_en)) ? $this->title_en : $this->title_id,
            'excerpt' => ($locale === 'en' && filled($this->excerpt_en)) ? $this->excerpt_en : $this->excerpt_id,
            'body' => ($locale === 'en' && filled($this->body_en)) ? $this->body_en : $this->body_id,
            'category' => $this->category,
            'featured_image' => $this->featured_image,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'status' => $this->status,
            'published_at' => $this->published_at?->format('d M Y'),
            'author_name' => $this->author?->name ?? 'PT. CARANO UTAMA LOGISTIK',
        ];
    }
}
