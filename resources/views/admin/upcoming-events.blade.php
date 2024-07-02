@extends('admin.layouts.layout')

@section('page-title')
    Upcoming Events | Admin Panel
@endsection

@section('content')
    @session('success')
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        {{ $value }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

    @if(count($events))
        <div class="card table-responsive shadow-sm p-3">
            <table class="table align-middle" style="font-size: 14px">
                <thead>
                <tr>
                    <th>Event</th>
                    <th>Description</th>
                    <th class="text-nowrap">Start Date</th>
                    <th class="text-nowrap">End Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-nowrap"></th>
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
                                    <a href="{{ route('home.show-event', $event) }}" class="mb-0 text-sm fw-normal">{{ $event->title }}</a>
                                </div>
                            </div>
                        </th>
                        <td>{{ $event->description }}</td>
                        <td class="text-nowrap">{{ $event->start_date }}</td>
                        <td class="text-nowrap">{{ $event->end_date }}</td>
                        <td class="text-center fs-6">{!! $event->status == 1 ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-danger">Canceled</span>' !!}</td>
                        <td class="text-nowrap">
                            <a class="btn btn-sm btn-danger" type="button" href="{{ route('join-event', $event) }}">Leave Event</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No Events Found!</p>
    @endif
@endsection