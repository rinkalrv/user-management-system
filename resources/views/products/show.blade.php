@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Product Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text"><strong>Description:</strong> {{ $product->description ?? 'N/A' }}</p>
            <p class="card-text"><strong>Category:</strong> {{ $product->category->name }}</p>
            <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p class="card-text"><strong>Quantity:</strong> {{ $product->quantity }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst($product->status) }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ $product->created_at->format('M d, Y H:i') }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ $product->updated_at->format('M d, Y H:i') }}</p>
            
            <div class="mt-3">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection