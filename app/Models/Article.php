<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [
        'genre_id',
        'title',
        'summary',
        'content',
        'status',
        'published_at',
        'featured_image',
        'author_name',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    // Scope only published and live
    public function scopeLive($query)
    {
        return $query->where('status', 'Published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

public function isSaved(): bool
{
    return \App\Models\SavedArticle::where('session_id', session()->getId())
        ->where('article_id', $this->id)
        ->exists();
}
}