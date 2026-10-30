<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleSummary;
use LLPhant\Chat\OpenAIChat;
use LLPhant\OpenAIConfig;
use RuntimeException;

class ArticleSummaryGenerator
{
    public function generate(Article $article): ArticleSummary
    {
        $config = new OpenAIConfig();
        $config->apiKey = config('services.deepinfra.api_key');
        $config->url = config('services.deepinfra.base_url');
        $config->model = config('services.deepinfra.model');

        $chat = new OpenAIChat($config);

        $chat->setSystemMessage(
            'You summarize blog articles accurately and concisely. '
            . 'Return only a plain-text TL;DR of no more than 3 sentences. '
            . 'Do not use Markdown, HTML, headings, or invented information.'
        );

        $prompt = "Title:\n{$article->title}\n\n"
            . "Article content:\n{$article->content}";

        $summary = trim($chat->generateText($prompt));

        if ($summary === '') {
            throw new RuntimeException(
                "The LLM returned an empty summary for article {$article->id}."
            );
        }

        return ArticleSummary::updateOrCreate(
            ['article_id' => $article->id],
            [
                'summary' => $summary,
                'model' => config('services.deepinfra.model'),
            ],
        );
    }
}
