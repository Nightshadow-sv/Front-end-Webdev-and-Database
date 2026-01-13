<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedArticle extends Model {
    protected $fillable = ['session_id','article_id'];
    public function article(): BelongsTo {
        return $this->belongsTo(Article::class);
    }
}