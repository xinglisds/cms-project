<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Article $article): RedirectResponse
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to comment.');
        }

        // Validate the comment content
        $validated = $request->validate([
            'content' => 'required|string|max:1000|min:3',
        ]);

        // Create the comment
        Comment::create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return redirect()->route('articles.show', $article->slug)
            ->with('success', 'Comment added successfully!');
    }
} 