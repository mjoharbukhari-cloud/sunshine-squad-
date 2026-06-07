@extends('layouts.app')

@section('content')
<style>
    .luxury-card { background-color: #121416 !important; border: 1px solid #23272a; border-radius: 12px; height: 100%; transition: 0.3s; cursor: pointer; }
    .luxury-card:hover { border-color: #d4af37; transform: translateY(-5px); }
    .card-img-top { height: 180px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px; }
    .gold-text { color: #d4af37 !important; }
    .btn-cart { background: #198754; color: white; width: 100%; border: none; }
    .btn-buy { background: #ffc107; color: black; font-weight: bold; width: 100%; }
</style>

<h2 class="text-center mb-4 gold-text fw-bold">Exclusive Deals & Services</h2>

<div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
  @forelse($deals as $deal)
    <div class="col">
      <!-- Card triggers modal -->
      <div class="card luxury-card" data-bs-toggle="modal" data-bs-target="#dealModal{{ $deal->id }}">
        <img src="{{ $deal->image ? asset('storage/'.$deal->image) : '/images/deal-placeholder.jpg' }}" class="card-img-top" alt="{{ $deal->title }}">
        <div class="card-body text-center d-flex flex-column">
          <h5 class="card-title gold-text">{{ $deal->title }}</h5>
          <p class="card-text text-muted small">{{ Str::limit($deal->description, 60) }}</p>
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
<script>
    function guestRedirect() { 
        alert('⚠️ Please log in or register to shop.'); 
        window.location.href = "{{ route('login') }}"; 
    }
</script>
@endsection