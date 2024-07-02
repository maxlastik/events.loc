<?php

namespace App\Services;

use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventService
{
    public function store($data, EventStoreRequest $request)
    {
        // Upload image to "images" folder
        $eventImageNewName = uniqid('event_', true).'.'.$request->image->extension();
        $request->image->storeAs('public/images/events', $eventImageNewName);

        $data['image'] = $eventImageNewName;

        $event = Event::create($data);

        if ($request->has('categories')) {
            $event->categories()->attach($request['categories']);
        }
    }

    public function update($event, $data, EventUpdateRequest $request)
    {
        if ($request->has('image')) {
            // Upload image to "images" folder and delete old one
            $eventImageNewName = uniqid('event_', true).'.'.$request->image->extension();
            $request->image->storeAs('public/images/events', $eventImageNewName);

            if (($event->image != '') && (Storage::exists('/public/images/events/'.$event->image))) {
                Storage::delete('/public/images/events/'.$event->image);
            }

            $data['image'] = $eventImageNewName;
        }

        $event->update($data);

        if ($request->has('categories')) {
            $event->categories()->sync($request['categories']);
        }
    }

    public function destroy($event)
    {
        $event->categories()->detach();

        if (($event->image != '') && (Storage::exists('/public/images/events/'.$event->image))) {
            Storage::delete('/public/images/events/'.$event->image);
        }

        $event->delete();
    }
}