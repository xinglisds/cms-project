<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class SubscriberController extends Controller
{
    /**
     * Store a new newsletter subscription.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = $request->input('email');

        // Check if email already exists
        if (Subscriber::where('email', $email)->exists()) {
            return back()->with('error', 'This email is already subscribed to our newsletter.');
        }

        // Create new subscription
        Subscriber::create(['email' => $email]);

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
