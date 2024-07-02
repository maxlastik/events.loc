@extends('admin.layouts.layout')

@section('page-title')
    User Management | Admin Panel
@endsection

@section('content')
    <h4 class="mb-3">Manage Users</h4>

    @session('success')
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        {{ $value }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

    @if(count($users))
        <div class="card table-responsive shadow-sm p-3">
            <table class="table align-middle" style="font-size: 14px">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Status</th>
                    <th class="text-nowrap">Created At</th>
                    <th class="text-nowrap">Updated At</th>
                    <th class="text-end"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-nowrap">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center fs-6">{!! $user->status == 1 ? '<i class="bi bi-person-check text-success"></i>' : '<i class="bi bi-person-slash text-danger"></i>' !!}</td>
                        <td class="text-nowrap">{{ $user->created_at }}</td>
                        <td class="text-nowrap">{{ $user->updated_at }}</td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.users.ban', $user) }}">{{ $user->status == 1 ? 'Ban' : 'Restore' }}</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
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
    @else
        <p>No members found</p>
    @endif

@endsection