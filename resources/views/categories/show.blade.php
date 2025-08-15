@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Category Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $category->name }}</h5>
            <p class="card-text"><strong>Description:</strong> {{ $category->description ?? 'N/A' }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst($category->status) }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ $category->created_at->format('M d, Y H:i') }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ $category->updated_at->format('M d, Y H:i') }}</p>
            
            <div class="mt-3">
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection