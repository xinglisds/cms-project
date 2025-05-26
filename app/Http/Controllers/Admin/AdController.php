<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ad::orderBy('id', 'asc')->paginate(10);
        return view('admin.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if we already have 3 ads
        if (Ad::count() >= 3) {
            return redirect()->route('admin.ads.index')
                ->with('error', 'Maximum 3 ads allowed. Please delete an existing ad before creating a new one.');
        }

        return view('admin.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if we already have 3 ads
        if (Ad::count() >= 3) {
            return redirect()->route('admin.ads.index')
                ->with('error', 'Maximum 3 ads allowed. Please delete an existing ad before creating a new one.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'target_url' => 'required|url',
            'position' => 'required|in:header,footer',
            'active_from' => 'required|date',
            'active_to' => 'required|date|after:active_from',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('ads');
        }

        Ad::create($validated);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        return view('admin.ads.show', compact('ad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'target_url' => 'required|url',
            'position' => 'required|in:header,footer',
            'active_from' => 'required|date',
            'active_to' => 'required|date|after:active_from',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($ad->image) {
                Storage::delete($ad->image);
            }
            $validated['image'] = $request->file('image')->store('ads');
        }

        $ad->update($validated);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        // Delete image file
        if ($ad->image) {
            Storage::delete($ad->image);
        }

        $ad->delete();

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad deleted successfully.');
    }
}
