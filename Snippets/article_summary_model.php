<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleSummary extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleSummaryFactory> */
    use HasFactory;

    protected $fillable = [
        'article_id',
        'summary',
        'model'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
