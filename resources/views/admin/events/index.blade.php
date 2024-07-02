@extends('admin.layouts.layout')

@section('page-title')
    Event Management | Admin Panel
@endsection

@section('content')
    <h4 class="mb-3">Manage Events</h4>

    @session('success')
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        {{ $value }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

    <a href="{{ route('admin.events.create') }}" type="button" class="btn btn-primary mb-3">New Event</a>

    <div class="card table-responsive shadow-sm p-3">
        <table class="table align-middle" style="font-size: 14px">
            <thead>
            <tr>
                <th>Event</th>
                <th>Description</th>
                <th class="text-nowrap">Start Date</th>
                <th class="text-nowrap">End Date</th>
                <th class="text-center">Members</th>
                <th class="text-center">Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <th>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3 flex-shrink-0">
                                <img alt="Image placeholder" src="{{ asset('storage/images/events/'.$event->image) }}" class="w-100 img-thumbnail">
                            </div>
                            <div class="flex-shrink-1">
                                <a href="{{ route('home.show-event',$event) }}" class="mb-0 text-sm fw-normal">{{ $event->title }}</a>
                            </div>
                        </div>
                    </th>
                    <td>{{ $event->description }}</td>
                    <td class="text-nowrap">{{ date('j M Y H:i',strtotime($event->start_date)) }}</td>
                    <td class="text-nowrap">{{ date('j M Y H:i',strtotime($event->end_date)) }}</td>
                    <td class="text-center">{{ count($event->users) }}</td>
                    <td class="text-center fs-6">{!! $event->status == 1 ? '<i class="bi bi-eye text-primary"></i>' : '<i class="bi bi-eye-slash text-danger"></i>' !!}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.events.edit', $event) }}">Edit</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.events.publish', $event) }}">{{ $event->status == 1 ? 'Unpublish' : 'Publish' }}</a>
                                </li>
                                <li>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="dropdown-item">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection