@extends('admin.layouts.layout')

@section('page-title')
    New Event | Admin Panel
@endsection

@section('content')
    <h4 class="mb-3">New Event</h4>

    <div class="card shadow-sm p-3">
        <!--begin::Form-->
        <form class="form" enctype="multipart/form-data" method="POST" action="{{ route('admin.events.store') }}" id="new-event-form">
            @csrf

            <!--begin::Card body-->
            <div class="card-body p-9">
                <div class="mb-3">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="">
                    @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description *</label>
                    <textarea class="form-control" id="description" rows="4" name="description" placeholder=""></textarea>
                    @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <p style="margin-bottom: 8px;  color: #000; font-size: 16px">Image *</p>
                    <div class="position-relative border rounded" style="width: 300px; height: 300px">
                        <a class="remove-item position-absolute badge rounded-circle bg-danger p-2 d-none" style="top: -3%; right: -3%; cursor: pointer;" id="cover_remove" onclick="onRemoveCoverClick(event)"><i class="bi bi-x-lg"></i></a>
                        <label for="cover_file_input" style="cursor: pointer">
                            <img src="/images/cover_default.png" class="rounded img-fluid" id="cover_image" style="aspect-ratio: 1/1; object-fit: contain;">
                        </label>
                        <input type="file" class="d-none" name="image" id="cover_file_input" onchange="onNewCoverSelected(event)">
                    </div>

                    @error('image')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-select" id="status" data-placeholder="Select status" name="status">
                        <option value="">Select status...</option>
                        <option value="0">Unpublished</option>
                        <option value="1">Published</option>
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
                                <input class="form-check-input me-1" type="checkbox" value="{{ $category->id }}" id="categoryCheckbox{{ $category->id }}" name="categories[]">
                                <label class="form-check-label stretched-link" for="categoryCheckbox{{ $category->id }}">{{ $category->name }}</label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mb-3">
                    <label class="form-label">Start Datetime *</label>
                    <input class="form-control" type="datetime-local" name="start_date">
                    @error('start_date')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">End Datetime *</label>
                    <input class="form-control" type="datetime-local" name="end_date">
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

        function onRemoveCoverClick(event) {
            coverRemoveButton.classList.add('d-none');
            coverFileInput.value = '';
            coverFileInput.disabled = false;
            coverImage.src = '/images/cover_default.png';
            coverImage.parentElement.style.cursor = 'pointer';
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
            if (coverFileInput.value == '') {
                alert('The image field cannot be empty.');
            } else {
                coverFileInput.disabled = false;
                document.getElementById("new-event-form").submit();
            }
        }
    </script>
@endsection