@extends('layouts.layout')

@section('page-title')
    {{ $event->title }} | Explore Events!
@endsection

@section('content')
    <div class="row flex-lg-row-reverse align-items-center justify-content-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-5">
            <img src="{{ asset('storage/images/events/'.$event->image) }}" class="d-block mx-lg-auto img-fluid rounded" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-7">
            <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">{{ $event->title }}</h1>
            <p class="lead">{{ $event->description }}</p>
            <p class="lead">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar4-event me-2" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                    <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                </svg>
                <span class="me-4">{{ date('j M Y',strtotime($event->start_date)) }}</span>

                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock me-2" viewBox="0 0 16 16">
                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"></path>
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"></path>
                </svg>
                <span>{{ date('H:i',strtotime($event->start_date)) }}</span>
            </p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                @if(Auth::check() && Auth::user()->events->contains($event))
                    <a type="button" href="{{ route('join-event', $event) }}" class="btn btn-lg btn-danger px-4 me-md-2" >Left Event</a>
                @else
                    <a type="button" href="{{ route('join-event', $event) }}" class="btn btn-lg btn-primary px-4 me-md-2">Join</a>
                @endif

            </div>
        </div>
    </div>
@endsection