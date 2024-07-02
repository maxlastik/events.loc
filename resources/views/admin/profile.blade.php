@extends('admin.layouts.layout')

@section('page-title')
    Profile | Admin Panel
@endsection

@section('content')
    <div class="my-3 p-3 bg-body rounded shadow-sm border">
        <h6 class="border-bottom pb-2 mb-4">Profile</h6>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Your profile has been updated.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('admin.profile.update') }}">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                @error('email')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="border rounded p-3 mt-2 bg-light">
                        <p>Your email address is unverified.</p>
                        <button form="send-verification" class="btn btn-secondary">Click here to re-send the verification email</button>
                        @if (session('status') === 'verification-link-sent')
                            <p class="text-success">A new verification link has been sent to your email address.</p>
                        @endif
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="my-3 p-3 bg-body rounded shadow-sm border">
        <h6 class="border-bottom pb-2 mb-4">Update Password</h6>

        @if (session('status') === 'password-updated')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Your password has been updated.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="update_password_current_password" name="current_password">
                @error('current_password','updatePassword')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="update_password_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="update_password_password" name="password">
                @error('password','updatePassword')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation">
                @error('password_confirmation','updatePassword')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="my-3 p-3 bg-body rounded shadow-sm border">
        <h6 class="border-bottom pb-2 mb-4">Delete Account</h6>

        <form method="post" action="{{ route('admin.profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                @error('password','userDeletion')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection