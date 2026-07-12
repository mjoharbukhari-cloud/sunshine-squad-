@extends('layouts.app')

@section('content')
<div class="hero text-center p-5 luxury-card rounded fade-up ">
    <h1 class="fw-bold gold-text">Sunshine Squad Marketplace</h1>
    <p class="lead" style="color:#dbe3f4">Find solar products, IoT devices, and smart services.</p>
</div>

{{-- ---------------- Deals Section ---------------- --}}
<h2 class="mt-5 mb-3 text-center gold-text">Hot Deals & Services</h2>

@php
    $totalDeals = isset($deals) ? $deals->take(3)->toArray() : [];
    $dummyDeals = [];
    for ($i = 1; $i <= 3; $i++) {
        $dummyDeals[] = [
            'id' => 100 + $i,
            'title' => "Demo Deal $i",
            'description' => "Sample description for demo purposes.",
            'price' => 100 * $i,
            'image' => "/images/deal-placeholder.jpg"
        ];
    }
    $displayDeals = array_merge($totalDeals, array_slice($dummyDeals, 0, 3 - count($totalDeals)));
@endphp
<style>
    .luxury-card { background-color: #151b2d !important; border: 1px solid #23272a; border-radius: 12px; height: 100%; transition: 0.3s; cursor: pointer; }
    .luxury-card:hover { border-color: #d4af37; transform: translateY(-5px); }
    .card-img-top { height: 180px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px; }
    .gold-text { color: #d4af37 !important; }
    .btn-cart { background: #198754; color: white; width: 100%; border: none; }
    .btn-buy { background: #ffc107; color: black; font-weight: bold; width: 100%; }
</style>

<div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
  @forelse($deals as $deal)
    <div class="col">
      <!-- Card triggers modal -->
      <div class="card luxury-card" data-bs-toggle="modal" data-bs-target="#dealModal{{ $deal->id }}">
        <img src="{{ $deal->image ? asset('storage/'.$deal->image) : '/images/deal-placeholder.jpg' }}" class="card-img-top" alt="{{ $deal->title }}">
        <div class="card-body text-center d-flex flex-column">
          <h5 class="card-title gold-text">{{ $deal->title }}</h5>
          <p class="card-text  small">{{ Str::limit($deal->description, 60) }}</p>
          <h6 class="mt-auto mb-3">Price: Rs {{ number_format($deal->price, 0) }}</h6>
          
          <div class="mt-auto" onclick="event.stopPropagation()">
            <a href="{{ route('marketplace.buy', ['product' => 0, 'deal_id' => $deal->id]) }}" class="btn btn-buy btn-sm">Grab Deal</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Centered Modal -->
    <div class="modal fade" id="dealModal{{ $deal->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-dark text-white border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title gold-text">{{ $deal->title }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5"><img src="{{ asset('storage/'.$deal->image) }}" class="img-fluid rounded border border-secondary"></div>
                        <div class="col-md-7">
                            <h3 class="text-warning">Rs {{ number_format($deal->price, 0) }}</h3>
                            <p>{{ $deal->description }}</p>
                            
                            <div class="d-flex gap-2 mt-3">
                                <form method="POST" action="{{ route('cart.add.deal', $deal->id) }}" class="w-100">
                                    @csrf <button class="btn btn-cart">Add Deal to Cart</button>
                                </form>
                                <a href="{{ route('marketplace.buy', ['product' => 0, 'deal_id' => $deal->id]) }}" class="btn btn-buy">Grab Deal Now</a>
                            </div>

                            <h6 class="mt-4 gold-text">Related Deals</h6>
                            <div class="d-flex gap-2 overflow-auto py-2">
                                @foreach(\App\Models\Deal::where('id', '!=', $deal->id)->limit(4)->get() as $related)
                                    <div class="card bg-secondary text-white" style="min-width: 100px; cursor: pointer;" onclick="window.location.href='{{ route('marketplace.deals.show', $related->id) }}'">
                                        <div class="p-1 text-center small text-truncate">{{ $related->title }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr class="border-secondary my-4">
                    <h6>Customer Reviews</h6>
                    <div class="review-box mb-3 bg-secondary p-3 rounded" style="max-height: 200px; overflow-y: auto;">
                        @forelse($deal->reviews as $review)
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
                        <input type="hidden" name="reviewable_id" value="{{ $deal->id }}">
                        <input type="hidden" name="reviewable_type" value="App\Models\Deal">
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
  @empty
    <div class="col-12 text-center text-white-50">No deals available.</div>
  @endforelse
</div>  
<!-- <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-3 g-4 mb-3">
    @foreach($displayDeals as $deal)
        <div class="col">
            <div class="card luxury-card h-100 fade-up">
                <img src="{{ $deal['image'] ?? '/images/deal-placeholder.jpg' }}" class="card-img-top" alt="{{ $deal['title'] }}">
                <div class="card-body text-center">
                    <h5 class="card-title gold-text"><strong>{{ $deal['title'] }}</strong></h5>
                    <p class="card-text">{{ Str::limit($deal['description'], 50) }}</p>
                    <h6 class="mt-2">Price: Rs {{ $deal['price'] }}</h6>

                    @auth
                    <button class="btn btn-warning btn-sm" data-bs-toggle="offcanvas" data-bs-target="#dealCanvas{{ $deal['id'] }}">Grab Deal</button>
                    @else
                    <button class="btn btn-warning btn-sm" onclick="guestRedirect()">Grab Deal</button>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Deal Offcanvas --}}
        @auth
        <div class="offcanvas offcanvas-end bg-dark text-white" id="dealCanvas{{ $deal['id'] }}" tabindex="-1">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title gold-text">{{ $deal['title'] }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <img src="{{ $deal['image'] ?? '/images/deal-placeholder.jpg' }}" class="img-fluid mb-3">
                <p><strong>Description:</strong> {{ $deal['description'] }}</p>
                <p><strong>Price:</strong> Rs {{ $deal['price'] }}</p>

                <form method="POST" action="{{ route('cart.add', $deal['id']) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Grab Deal</button>
                </form>
            </div>
        </div>
        @endauth
    @endforeach
</div> -->

<div class="text-center mt-3">
    <a href="{{ route('marketplace.deals') }}" class="btn btn-warning">See More Deals</a>
</div>

<!-- {{-- ---------------- Products Section ---------------- --}}
<h2 class="mt-5 mb-3 text-center gold-text"> Featured Products</h2>

<div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4 mb-3" id="productContainer">
   @foreach($products as $index => $product)
    <div class="col product-card" style="{{ $index >= 8 ? 'display:none;' : '' }}">
        <div class="card luxury-card h-100 fade-up">
            <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body text-center">
                <h5 class="card-title"><strong>{{ $product->name }}</strong></h5>
                <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                <strong>Rs {{ $product->price }}</strong>
                
                <div class="mt-2 d-flex justify-content-center gap-2">
                    @auth
                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
                    </form>
                    <a href="{{ route('marketplace.buy', $product->id) }}?quantity=1" class="btn btn-warning btn-sm">Buy Now</a>
                    @else
                    <button class="btn btn-success btn-sm" onclick="guestRedirect()">Add to Cart</button>
                    <button class="btn btn-warning btn-sm" onclick="guestRedirect()">Buy Now</button>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Product Offcanvas --}}
        @auth
        <div class="offcanvas offcanvas-end bg-dark text-white" id="productCanvas{{ $product->id }}" tabindex="-1">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">{{ $product->name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="img-fluid mb-3">
                <p><strong>Description:</strong> {{ $product->description }}</p>
                <p><strong>Price:</strong> Rs {{ $product->price }}</p>
            </div>
        </div>
        @endauth
    </div>
@endforeach
</div> -->

 <h2 class="mt-5 mb-3 text-center gold-text"> Featured Products</h2>
<div class="row row-cols-3 row-cols-md-4 row-cols-xl-6 g-3">
   
    @foreach($products as $product)
    <div class="col">
        <!-- Card triggers modal using native Bootstrap data attributes -->
        <div class="card luxury-card" data-bs-toggle="modal" data-bs-target="#prodModal{{ $product->id }}">
            <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body p-2 d-flex flex-column">
                <h6 class="text-white fw-bold text-truncate">{{ $product->name }}</h6>
                <p class="small mb-2">{{ Str::limit($product->description, 30) }}</p>
                
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
                    <div class="mt-auto" onclick="event.stopPropagation()">
                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf <button type="submit" class="btn btn-sm btn-cart mb-1">Add to Cart</button>
                    </form>
                    <a href="{{ route('marketplace.buy', $product->id) }}" class="btn btn-sm btn-buy">Buy Now</a>
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
@endsection

@section('scripts')
<script>
function guestRedirect() {
    alert('⚠️ Please register or log in to continue.');
    window.location.href = "{{ route('login') }}";
}



</script>
@endsection