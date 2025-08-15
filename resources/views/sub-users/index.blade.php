@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sub Users</h1>
    <a href="{{ route('sub-users.create') }}" class="btn btn-primary mb-3">Add New Sub User</a>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile No</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subUsers as $subUser)
                <tr>
                    <td>{{ $subUser->user_id }}</td>
                    <td>{{ $subUser->user_name }}</td>
                    <td>{{ $subUser->email }}</td>
                    <td>{{ $subUser->user_mobile_no }}</td>
                    <td>{{ ucfirst($subUser->user_type) }}</td>
                    <td>{{ ucfirst($subUser->user_status) }}</td>
                    <td>
                        <a href="{{ route('sub-users.show', $subUser->user_id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('sub-users.edit', $subUser->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('sub-users.destroy', $subUser->user_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection