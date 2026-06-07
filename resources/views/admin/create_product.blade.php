@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New Product</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Alert block to catch input bugs immediately --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="Enter product name">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter product description">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price') }}" required placeholder="Enter product price">
        </div>

        <div class="mb-3">
            <label for="shop_id" class="form-label">Assign to Shop / Vendor</label>
            <select name="shop_id" id="shop_id" class="form-control" required>
                <option value="">-- Select Active Shop Entity --</option>
                @foreach($shops as $shop)
                    <option value="{{ $shop->id }}" {{ old('shop_id') == $shop->id ? 'selected' : '' }}>
                        {{ $shop->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Add Product</button>
    </form>
</div>
@endsection