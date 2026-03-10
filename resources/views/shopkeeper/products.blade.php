@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Your Products</h2>

    <a href="{{ route('shopkeeper.products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    @if($products->isEmpty())
        <p>No products added yet.</p>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body text-center">
                            <h5>{{ $product->name }}</h5>
                            <p>Rs{{ $product->price }}</p>
                            <a href="{{ route('shopkeeper.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('shopkeeper.products.delete', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
