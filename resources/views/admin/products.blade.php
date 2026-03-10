@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Products</h1>

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Shop</th>
                <th>Price</th>
                <th>Approved</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->shop->name ?? 'N/A' }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->approved ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    @if(!$product->approved)
                    <form action="{{ route('admin.products.approve', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-sm btn-success">Approve</button>
                    </form>
                    @endif
                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
