@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New User</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_name">Name</label>
            <input type="text" class="form-control" id="user_name" name="user_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="user_mobile_no">Mobile No</label>
            <input type="text" class="form-control" id="user_mobile_no" name="user_mobile_no">
        </div>
        <div class="form-group">
            <label for="user_type">User Type</label>
            <select class="form-control" id="user_type" name="user_type" required>
                <option value="admin">Admin</option>
                <option value="user" selected>User</option>
                <option value="employee">Employee</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection