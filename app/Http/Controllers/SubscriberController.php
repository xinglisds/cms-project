<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Mail\SubscriptionConfirmation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
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

        try {
            // Create new subscription
            Subscriber::create(['email' => $email]);

            // Send confirmation email
            Mail::to($email)->send(new SubscriptionConfirmation($email));

            Log::info('Newsletter subscription successful', [
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return back()->with('success', 'Thank you for subscribing! A confirmation email has been sent to your inbox.');

        } catch (\Exception $e) {
            Log::error('Newsletter subscription failed', [
                'email' => $email,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            // If email sending fails, still show success to user but log the error
            return back()->with('success', 'Thank you for subscribing to our newsletter!');
        }
    }
}
