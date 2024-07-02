@extends('admin.layouts.layout')

@section('page-title')
    Dashboard | Admin Panel
@endsection

@section('content')
    <div class="my-3 p-3 bg-body rounded shadow-sm border">
        <h6 class="border-bottom pb-2 mb-0">Recent Users</h6>
        @foreach($recentUsers as $user)
            <div class="d-flex text-body-secondary pt-3">
                <div class="flex-shrink-0 me-2 rounded justify-content-center d-flex align-items-center" style="width: 32px; height: 32px; background-color: #bee5ec">
                    <b>{{ $user->name[0] }}</b>
                </div>
                <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
                    <strong class="d-block text-gray-dark">{{ $user->name }}</strong>
                    {{ $user->email }}
                </p>
            </div>
        @endforeach

        <small class="d-block text-end mt-3">
            <a href="{{ route('admin.users.index') }}">All Users</a>
        </small>
    </div>

    <div class="my-3 p-3 bg-body rounded shadow-sm border">
        <h6 class="border-bottom pb-2 mb-0">Recent Events</h6>
        @foreach($recentEvents as $event)
            <div class="d-flex text-body-secondary pt-3">
                <img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="{{ asset('storage/images/events/'.$event->image) }}">
                <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
                    <strong class="d-block text-gray-dark">{{ $event->title }}</strong>
                    {{ $event->description }}
                </p>
            </div>
        @endforeach

        <small class="d-block text-end mt-3">
            <a href="{{ route('admin.events.index') }}">All Events</a>
        </small>
    </div>
@endsection
