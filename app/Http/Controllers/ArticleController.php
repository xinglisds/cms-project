<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index(): View
    {
        $articles = Article::withCount('comments')->latest()->paginate(12);
        
        return view('articles.index', compact('articles'));
    }

    /**
     * Display the specified article.
     */
    public function show(string $slug): View
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        // Load comments with user relationship for displaying
        $article->load(['comments' => function ($query) {
            $query->with('user')->latest();
        }]);
        
        return view('articles.show', compact('article'));
    }
}
