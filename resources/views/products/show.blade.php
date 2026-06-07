@extends('layouts.app')

@section('content')
<div class="container py-5 text-white">
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card bg-dark border-secondary p-3">
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top rounded" alt="{{ $product->name }}">
                <div class="card-body">
                    <h1 class="fw-bold">{{ $product->name }}</h1>
                    <h3 class="text-warning">Rs. {{ number_format($product->price, 2) }}</h3>
                    <p class="text-muted mt-3">{{ $product->description }}</p>
                    <p><strong>Shop:</strong> <span class="text-info">{{ $product->shop->name }}</span></p>

                    <div class="d-flex gap-3 mt-4">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-lg px-4"><i class="fa-solid fa-cart-plus me-2"></i>Add to Cart</button>
                        </form>
                        <a href="{{ route('marketplace.buy', $product->id) }}" class="btn btn-warning btn-lg px-4"><i class="fa-solid fa-bolt me-2"></i>Buy Now</a>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h4 class="border-bottom border-secondary pb-2 mb-3">Customer Reviews</h4>
                @forelse($product->reviews as $review)
                    <div class="card bg-dark border-secondary mb-2 p-3">
                        <strong>{{ $review->user->name }}</strong>
                        <span class="text-warning">{{ str_repeat('★', $review->rating) }}</span>
                        <p class="small text-white-50">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-muted">No reviews yet for this product.</p>
                @endforelse
            </div>
        </div>

        <div class="col-md-4">
            <h4>Related Items</h4>
            @foreach($relatedProducts as $related)
                <div class="card bg-dark border-secondary mb-3 p-2">
                    <div class="row g-0">
                        <div class="col-4">
                            <img src="{{ asset('storage/' . $related->image) }}" class="img-fluid rounded" alt="...">
                        </div>
                        <div class="col-8 ps-2">
                            <h6 class="mb-0">{{ $related->name }}</h6>
                            <small class="text-warning">Rs. {{ number_format($related->price, 0) }}</small>
                            <a href="{{ route('marketplace.products.show', $related->id) }}" class="d-block text-info small">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection