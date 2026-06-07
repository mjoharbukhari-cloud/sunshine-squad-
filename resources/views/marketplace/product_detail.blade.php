@extends('layouts.app')

@section('content')
<div class="container py-5 text-white">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card bg-dark border-secondary p-4">
                <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded mb-4" style="max-height: 400px; width: 100%; object-fit: contain;">
                <h1>{{ $product->name }}</h1>
                <h2 class="text-warning fw-bold">Rs. {{ number_format($product->price, 2) }}</h2>
                <hr class="border-secondary">
                <p class="text-white-50">{{ $product->description }}</p>
                <div class="d-flex gap-3 mt-3">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-lg px-4">Add to Cart</button>
                    </form>
                    <a href="{{ route('marketplace.buy', $product->id) }}" class="btn btn-warning btn-lg px-4 text-dark fw-bold">Buy Now</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <h4 class="mb-3" style="color: #d4af37;">Similar Items</h4>
            @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related->id) }}" class="card bg-dark border-secondary p-2 mb-2 text-decoration-none text-white d-flex flex-row align-items-center">
                    <img src="{{ asset('storage/'.$related->image) }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                    <div>
                        <div class="fw-bold">{{ $related->name }}</div>
                        <div class="text-warning">Rs. {{ number_format($related->price, 0) }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection