@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sub User Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $subUser->user_name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $subUser->email }}</p>
            <p class="card-text"><strong>Mobile No:</strong> {{ $subUser->user_mobile_no ?? 'N/A' }}</p>
            <p class="card-text"><strong>User Type:</strong> {{ ucfirst($subUser->user_type) }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst($subUser->user_status) }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ $subUser->created_at->format('M d, Y H:i') }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ $subUser->updated_at->format('M d, Y H:i') }}</p>
            
            <div class="mt-3">
                <a href="{{ route('sub-users.edit', $subUser->user_id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('sub-users.destroy', $subUser->user_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                <a href="{{ route('sub-users.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection