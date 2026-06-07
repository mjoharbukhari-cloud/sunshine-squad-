@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Shop Association</label>
            <select name="shop_id" class="form-control" required>
                <option value="">Select Target Shop</option>
                @foreach($shops as $shop)
                    <option value="{{ $shop->id }}" {{ $product->shop_id == $shop->id ? 'selected' : '' }}>
                        {{ $shop->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            @if($product->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $product->image) }}" width="80" class="img-thumbnail">
                </div>
            @endif
        </div>

        <button class="btn btn-success">Update Product</button>
    </form>
</div>
@endsection