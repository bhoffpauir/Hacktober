/**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        // Retrieve the article with the given slug (a formatted form of the article name)
        $article = Article::with('summary')
            ->where('slug', $slug)
            ->firstOrFail();

        // Pass parameters to view
        return view('blog.read')->with([
            'article' => $article,
            'summary' => $article->summary,
            'comments' => $article->comments()->paginate(env('DEFAULT_PAGE_SIZE')),
            'commentCount' => $article->comments->count()
        ]);
    }
    
