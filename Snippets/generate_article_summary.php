<?php

 namespace App\Jobs;

 use App\Models\Article;
 use App\Services\ArticleSummaryGenerator;
 use Illuminate\Bus\Queueable;
 use Illuminate\Contracts\Queue\ShouldQueue;
 use Illuminate\Foundation\Bus\Dispatchable;
 use Illuminate\Queue\InteractsWithQueue;
 use Illuminate\Queue\SerializesModels;
 use Illuminate\Support\Facades\Log;
 use Throwable;

 class GenerateArticleSummary implements ShouldQueue
 {
     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     public int $tries = 3;

     public function __construct(
         public int $articleId
     ) {}

     public function backoff(): array
     {
         return [30, 120, 300];
     }

     public function handle(ArticleSummaryGenerator $generator): void
     {
         $article = Article::find($this->articleId);

         if (!$article) {
             return;
         }

         $generator->generate($article);
     }

     public function failed(Throwable $exception): void
     {
         Log::error('Article summary generation failed.', [
             'article_id' => $this->articleId,
             'exception' => $exception,
         ]);
     }
 }
