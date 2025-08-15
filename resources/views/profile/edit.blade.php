@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Profile</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="user_name" class="form-label">Name</label>
                            <input id="user_name" type="text" class="form-control" name="user_name" value="{{ old('user_name', $user->user_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="user_mobile_no" class="form-label">Mobile Number</label>
                            <input id="user_mobile_no" type="text" class="form-control" name="user_mobile_no" value="{{ old('user_mobile_no', $user->user_mobile_no) }}">
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input id="current_password" type="password" class="form-control" name="current_password">
                            <small class="text-muted">Only needed if changing password</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input id="new_password" type="password" class="form-control" name="new_password">
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection