@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile Information</div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <p>{{ $user->user_name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <p>{{ $user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mobile Number</label>
                        <p>{{ $user->user_mobile_no ?? 'Not provided' }}</p>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection