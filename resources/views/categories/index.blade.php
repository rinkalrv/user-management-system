@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categories</h1>
    
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>
        
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->category_id }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ ucfirst($category->status) }}</td>
                    <td>
                        
                        <a href="{{ route('categories.show', $category->category_id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" style="display:inline;">
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