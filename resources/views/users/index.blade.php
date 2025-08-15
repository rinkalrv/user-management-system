@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Users</h1>
    @can('manage-users')

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add New User</a>
    @endcan

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
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->user_mobile_no }}</td>
                    <td>{{ ucfirst($user->user_type) }}</td>
                    <td>{{ ucfirst($user->user_status) }}</td>
                    <td>
                        <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-info btn-sm">View</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('users.destroy', $user->user_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection