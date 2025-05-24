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
        
        // Check if this is for homepage or articles page
        if (request()->route()->getName() === 'home') {
            return view('home', compact('articles'));
        }
        
        return view('articles.index', compact('articles'));
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article): View
    {
        // Load comments with user relationship for displaying
        $article->load(['comments' => function ($query) {
            $query->with('user')->latest();
        }]);
        
        return view('articles.show', compact('article'));
    }
}
