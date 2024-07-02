@extends('admin.layouts.layout')

@section('page-title')
    Edit Event | Admin Panel
@endsection

@section('content')
    <h4 class="mb-3">Edit Event</h4>

    <div class="card shadow-sm p-3">
        <!--begin::Form-->
        <form class="form" enctype="multipart/form-data" method="POST" action="{{ route('admin.events.update', $event) }}" id="edit-event-form">
            @csrf
            @method('patch')

            <!--begin::Card body-->
            <div class="card-body p-9">
                <div class="mb-3">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter event title" value="{{ $event->title }}">
                    @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description *</label>
                    <textarea class="form-control" id="description" rows="4" name="description" placeholder="Type event details">{{ $event->description }}</textarea>
                    @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!--
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input class="form-control" type="file" id="image" name="image">

                </div>
                -->

                <div class="mb-3">
                    <p style="margin-bottom: 8px;  color: #000; font-size: 16px">Image *</p>
                    <div class="position-relative border rounded" style="width: 300px; height: 300px">
                        <a class="remove-item position-absolute badge rounded-circle bg-danger p-2" style="top: -3%; right: -3%; cursor: pointer;" id="cover_remove" onclick="onRemoveCoverClick(event)"><i class="bi bi-x-lg"></i></a>
                        <label for="cover_file_input" style="cursor: default">
                            <img src="{{ asset('storage/images/events/'.$event->image) }}" class="rounded img-fluid" id="cover_image" style="aspect-ratio: 1/1; object-fit: contain;">
                        </label>
                        <input type="file" class="d-none" name="image" id="cover_file_input" onchange="onNewCoverSelected(event)" disabled>
                        <input type="hidden" name="cover_hidden" id="cover_hidden" value=0>
                    </div>

                    @error('image')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-select" id="status" data-placeholder="Select status" name="status">
                        <option value="">Select status...</option>
                        <option value="0" {{ $event->status == 0 ? 'selected' : '' }}>Unpublished</option>
                        <option value="1" {{ $event->status == 1 ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Categories</label>
                    <ul class="list-group">
                        @foreach($categories as $category)
                            <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="{{ $category->id }}" id="categoryCheckbox{{ $category->id }}" name="categories[]" {{ $event->categories->contains($category->id) ? 'checked' : '' }}>
                                <label class="form-check-label stretched-link" for="categoryCheckbox{{ $category->id }}">{{ $category->name }}</label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mb-3">
                    <label class="form-label">Start Datetime *</label>
                    <input class="form-control" type="datetime-local" name="start_date" value="{{ $event->start_date }}">
                    @error('start_date')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">End Datetime *</label>
                    <input class="form-control" type="datetime-local" name="end_date" value="{{ $event->end_date }}">
                    @error('end_date')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <!--end::Card body-->

            <div class="text-end">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
                <button type="button" class="btn btn-primary" onclick="prepareAndSubmitForm()">Save</button>
            </div>
        </form>
        <!--end:Form-->

    </div>
@endsection

@section('custom-js')
    <script>
        const coverImage = document.getElementById("cover_image");
        const coverFileInput = document.getElementById("cover_file_input");
        const coverRemoveButton = document.getElementById("cover_remove");
        const coverHidden = document.getElementById("cover_hidden");

        function onRemoveCoverClick(event) {
            coverRemoveButton.classList.add('d-none');
            coverFileInput.value = '';
            coverFileInput.disabled = false;
            coverImage.src = '/images/cover_default.png';
            coverImage.parentElement.style.cursor = 'pointer';
            coverHidden.value = 1;
        }

        function onNewCoverSelected(event) {
            let fileTypes = ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp'];

            if (event.target.files.length > 0) {
                const selectedFile = event.target.files[0];

                let extension = selectedFile.name.split('.').pop().toLowerCase();  //file extension from input file
                let isSuccess = fileTypes.indexOf(extension) > -1;

                if (isSuccess) {
                    const reader = new FileReader();
                    reader.readAsDataURL(selectedFile);

                    reader.onload = function (event) {
                        const tmpImage = new Image();
                        tmpImage.src = reader.result;

                        tmpImage.onload = function () {
                            coverImage.src = reader.result;
                            coverImage.parentElement.style.cursor = 'default';
                            coverFileInput.disabled = true;
                            coverRemoveButton.classList.remove('d-none');
                        };
                    };
                } else {
                    coverFileInput.value = '';
                    alert('The image field must be an image.');
                }

            }
        }

        function prepareAndSubmitForm() {
            if ((coverHidden.value != 0) && (coverFileInput.value == '')) {
                alert('The image field cannot be empty.');
            } else {
                coverFileInput.disabled = false;
                document.getElementById("edit-event-form").submit();
            }
        }
    </script>
@endsection