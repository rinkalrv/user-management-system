@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Products</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ ucfirst($product->status) }}</td>        
                    <td>
                        <a href="{{ route('products.show', $product->product_id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('categories.edit', $product->product_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $product->product_id) }}" method="POST" style="display:inline;">
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