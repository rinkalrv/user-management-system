@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('users.update', $user->user_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="user_name">Name</label>
            <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $user->user_name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="user_mobile_no">Mobile No</label>
            <input type="text" class="form-control" id="user_mobile_no" name="user_mobile_no" value="{{ $user->user_mobile_no }}">
        </div>
        <div class="form-group">
            <label for="user_type">User Type</label>
            <select class="form-control" id="user_type" name="user_type" required>
                <option value="admin" {{ $user->user_type == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->user_type == 'user' ? 'selected' : '' }}>User</option>
                <option value="employee" {{ $user->user_type == 'employee' ? 'selected' : '' }}>Employee</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_status">Status</label>
            <select class="form-control" id="user_status" name="user_status" required>
                <option value="active" {{ $user->user_status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $user->user_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection