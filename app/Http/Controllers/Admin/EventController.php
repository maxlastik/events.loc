<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Models\Category;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public $service;

    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all()->sortByDesc('created_at');
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data, $request);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, Event $event)
    {
        $data = $request->validated();

        $this->service->update($event, $data, $request);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->service->destroy($event);

        return redirect()->route('admin.events.index')->with('success', 'Event has been deleted');
    }

    /**
     * Publish/Unpublish the specified resource.
     */
    public function publish(Event $event)
    {
        if ($event->status == 1) {
            $event->status = 0;
            $successMessage = 'Event has been unpublished';
        } else {
            $event->status = 1;
            $successMessage = 'Event has been published';
        }
        $event->save();

        return redirect()->route('admin.events.index')->with('success', $successMessage);
    }
}
