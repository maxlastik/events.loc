@extends('admin.layouts.layout')

@section('page-title')
    Edit Category | Admin Panel
@endsection

@section('content')
    <h4 class="mb-3">Edit Category</h4>

    <div class="card shadow-sm p-3">
        <form class="form" method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('patch')

            <div class="card-body p-9">
                <div class="mb-3">
                    <label for="title" class="form-label">Name *</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ $category->name }}">
                    @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Events</label>
                    <ul class="list-group">
                        @foreach($events as $event)
                            <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="{{ $event->id }}" id="eventCheckbox{{ $event->id }}" name="events[]" {{ $category->events->contains($event->id) ? 'checked' : '' }}>
                                <label class="form-check-label stretched-link" for="eventCheckbox{{ $event->id }}">{{ $event->title }}</label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="text-end">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
                <button type="sybmot" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection