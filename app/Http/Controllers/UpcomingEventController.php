<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class UpcomingEventController extends Controller
{
    /**
     * Display the user's upcoming events.
     */
    public function index()
    {
        $events = Auth::user()->events()->get();

        switch (Auth::user()->role) {
            case 1 : return view('admin.upcoming-events', compact('events'));
            case 2 : return view('member.upcoming-events', compact('events'));
        }
    }

    /**
     * Join or left event.
     */
    public function join(Event $event)
    {
        if (Auth::user()->events->contains($event)) {
            Auth::user()->events()->detach($event);
        } else {
            Auth::user()->events()->attach($event);
        }

        return redirect()->back();
    }
}
