<?php

namespace App\Observers;

use App\Jobs\GenerateArticleSummary;
use App\Models\Article;
use App\Models\ArticleSummary;

class ArticleObserver
{
    public function created(Article $article): void
    {
        GenerateArticleSummary::dispatch($article->id)->afterCommit();
    }

    public function updated(Article $article): void
    {
        if ($article->wasChanged(['title', 'description', 'content'])) {
            GenerateArticleSummary::dispatch($article->id)->afterCommit();
        }
    }

    public function deleted(Article $article): void
    {
        ArticleSummary::where('article_id', $article->id)->delete();
    }
}
