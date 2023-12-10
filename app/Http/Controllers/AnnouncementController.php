<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $request->user()->announcements()->create($validated);

        return redirect('/home')->with([
            'message' => 'Announcement posted successfully.',
        ]);
    }

    public function edit(Request $request, Announcement $announcement)
    {
        return view('announcements.edit', ['announcement' => $announcement]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $announcement->update($validated);

        return redirect('/home')->with([
            'message' => 'Announcement updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect('/home')->with([
            'message' => 'Announcement deleted successfully.',
        ]);
    }
}
