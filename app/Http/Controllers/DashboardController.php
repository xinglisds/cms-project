<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index(): View
    {
        // Get current user's comments with article relationship
        $userComments = Comment::with('article')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('userComments'));
    }
} 