@extends('admin.layouts.layout')

@section('page-title')
    Category Management | Admin Panel
@endsection

@section('content')
    <h4 class="mb-3">Manage Categories</h4>

    @session('success')
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        {{ $value }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

    <a href="{{ route('admin.categories.create') }}" type="button" class="btn btn-primary mb-3">New Category</a>

    <div class="card table-responsive shadow-sm p-3">
        <table class="table align-middle" style="font-size: 14px">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Events</th>
                <th class="text-nowrap">Created At</th>
                <th class="text-nowrap">Updated At</th>
                <th class="text-end"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-nowrap">{{ $category->name }}</td>
                    <td>{{ count($category->events) }}</td>
                    <td class="text-nowrap">{{ $category->created_at }}</td>
                    <td class="text-nowrap">{{ $category->updated_at }}</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                </li>
                                <li>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
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