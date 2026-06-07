@extends('layouts.app')

@section('content')
<style>
    .luxury-card { background-color: #121416 !important; border: 1px solid #23272a; border-radius: 12px; height: 100%; transition: 0.3s; cursor: pointer; }
    .luxury-card:hover { border-color: #d4af37; transform: translateY(-5px); }
    .card-img-top { height: 160px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px; }
    .gold-text { color: #d4af37 !important; }
    .btn-cart { background: #198754; color: white; width: 100%; border: none; }
    .btn-buy { background: #ffc107; color: black; font-weight: bold; width: 100%; display: block; text-align: center; text-decoration: none; padding: 5px; border-radius: 4px; }
    .review-box { max-height: 200px; overflow-y: auto; background: #1a1d21; padding: 10px; border-radius: 8px; }
</style>

<h2 class="text-center mb-4 gold-text fw-bold">All Products</h2>

<div class="row row-cols-3 row-cols-md-4 row-cols-xl-6 g-3">
    @foreach($products as $product)
    <div class="col">
        <!-- Card triggers modal using native Bootstrap data attributes -->
        <div class="card luxury-card" data-bs-toggle="modal" data-bs-target="#prodModal{{ $product->id }}">
            <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body p-2 d-flex flex-column">
                <h6 class="text-white fw-bold text-truncate">{{ $product->name }}</h6>
                <p class="small text-muted mb-2">{{ Str::limit($product->description, 30) }}</p>
                
                <!-- Stop propagation prevents clicking buttons from opening the modal -->
                <div class="mt-auto" onclick="event.stopPropagation()">
                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf <button type="submit" class="btn btn-sm btn-cart mb-1">Add to Cart</button>
                    </form>
                    <a href="{{ route('marketplace.buy', $product->id) }}" class="btn btn-sm btn-buy">Buy Now</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Centered Modal -->
    <div class="modal fade" id="prodModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-dark text-white border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title gold-text">{{ $product->name }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded border border-secondary">
                        </div>
                        <div class="col-md-7">
                            <h3 class="text-warning">Rs {{ number_format($product->price, 0) }}</h3>
                            <p class="text-light">{{ $product->description }}</p>
                            
                            <h6 class="mt-4 gold-text">Related Products</h6>
                            <div class="d-flex gap-2 overflow-auto py-2">
                                @foreach(\App\Models\Product::where('id', '!=', $product->id)->limit(4)->get() as $related)
                                    <div class="card bg-secondary text-white" style="min-width: 100px; cursor: pointer;" onclick="window.location.href='{{ route('products.show', $related->id) }}'">
                                        <img src="{{ asset('storage/'.$related->image) }}" class="card-img-top" style="height: 60px;">
                                        <div class="p-1 text-center small text-truncate">{{ $related->name }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <hr class="border-secondary my-4">
                    
                    <h6>Customer Reviews</h6>
                    <div class="review-box mb-3">
                        @forelse($product->reviews as $review)
                            <div class="border-bottom border-secondary mb-2 pb-1">
                                <strong>{{ $review->user->name ?? 'User' }}</strong>: {{ $review->comment }}
                            </div>
                        @empty
                            <p class="text-muted small">No reviews yet.</p>
                        @endforelse
                    </div>

                    @auth
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <input type="hidden" name="reviewable_id" value="{{ $product->id }}">
                        <input type="hidden" name="reviewable_type" value="App\Models\Product">
                        <select name="rating" class="form-select bg-dark text-white mb-2" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                             <option value="4">⭐⭐⭐ (3)</option>
                              <option value="4">⭐⭐ (2)</option>
                               <option value="4">⭐ (1)</option>
                        </select>
                        <textarea name="comment" class="form-control bg-dark text-white" placeholder="Write a review..." required></textarea>
                        <button type="submit" class="btn btn-primary mt-2">Post Review</button>
                    </form>
                    @else
                        <p class="text-warning small mt-2">Please login to post a review.</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-5">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
<script>
    function guestRedirect() { 
        alert('⚠️ Please log in or register to shop.'); 
        window.location.href = "{{ route('login') }}"; 
    }
</script>
@endsection