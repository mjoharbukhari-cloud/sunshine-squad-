@extends('layouts.app')

@section('content')
<h2 class="text-center mb-4 gold-text">Exclusive Deals & Services</h2>

<div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
  @forelse($deals as $deal)
    <div class="col">
      <div class="card luxury-card h-100 fade-up">
        <img src="{{ $deal->image ? asset('storage/'.$deal->image) : '/images/deal-placeholder.jpg' }}" class="card-img-top" alt="{{ $deal->title }}">
        <div class="card-body text-center">
          <h5 class="card-title gold-text">{{ $deal->title }}</h5>
          <p class="card-text">{{ Str::limit($deal->description, 80) }}</p>
          <h6 class="mt-2">Price: Rs {{ $deal->price }}</h6>

          <div class="d-flex justify-content-center gap-2 mt-3">
            <!-- Grab Deal Button -->
            <button class="btn btn-warning btn-sm"
                    onclick="@guest redirectToLogin() @else grabDeal({{ $deal->id }}) @endguest">
              Grab Deal
            </button>

            <!-- View Details Button -->
            <button class="btn btn-outline-warning btn-sm"
                    onclick="openDealModal({{ $deal->id }})">
              View Details
            </button>
          </div>
        </div>
      </div>
    </div>

    @auth
    <!-- Deal Offcanvas Modal -->
    <div class="offcanvas offcanvas-end bg-dark text-white" id="dealCanvas{{ $deal->id }}" tabindex="-1">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title gold-text">{{ $deal->title }} Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body">
        <img src="{{ $deal->image ? asset('storage/'.$deal->image) : '/images/deal-placeholder.jpg' }}" class="img-fluid rounded mb-3">
        <p><strong>Description:</strong> {{ $deal->description }}</p>
        <p><strong>Price:</strong> Rs {{ $deal->price }}</p>

        @if(auth()->check())
        <form method="POST" action="{{ route('cart.add', $deal->id) }}">
          @csrf
          <button type="submit" class="btn btn-warning">Grab Deal</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="btn btn-warning">Grab Deal</a>
        @endif
      </div>
    </div>
    @endauth

  @empty
    <p class="text-center">No deals available at the moment.</p>
  @endforelse
</div>
@endsection

@section('scripts')
<script>
function redirectToLogin() {
    alert('⚠️ Please register or log in first!');
    window.location.href = "{{ route('login') }}";
}

@auth
function openDealModal(id) {
    new bootstrap.Offcanvas(document.getElementById('dealCanvas' + id)).show();
}

function grabDeal(id) {
    // If you want to add directly to cart via AJAX, you can do it here
    // For now, just submit a form in offcanvas
    openDealModal(id);
}
@endauth
</script>
@endsection
