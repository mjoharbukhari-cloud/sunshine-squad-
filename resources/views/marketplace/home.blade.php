@extends('layouts.app')

@section('content')
<div class="hero text-center p-5 luxury-card rounded fade-up">
  <h1 class="fw-bold gold-text">Sunshine Squad Marketplace</h1>
  <p class="lead" style="color:#dbe3f4">Find solar products, IoT devices, and smart services.</p>
</div>

{{-- Deals Section --}}
<h2 class="mt-5 mb-3 text-center gold-text">🔥 Deals & Services</h2>
<div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4 mb-4">
  @for($i=1; $i<=3; $i++)
    <div class="col">
      <div class="card luxury-card h-100 fade-up">
        <img src="/images/deal{{$i}}.jpg" class="card-img-top" alt="Deal {{$i}}">
        <div class="card-body text-center">
          <h5 class="card-title"><strong>Deal {{$i}}</strong></h5>
          <p class="card-text">Special bundle offer.</p>
          <button class="btn btn-warning btn-sm" data-bs-toggle="offcanvas" data-bs-target="#dealCanvas{{$i}}">
            Grab Deal
          </button>
        </div>
      </div>
    </div>

    {{-- Deal Offcanvas (black sidebar with white cross button) --}}
    <div class="offcanvas offcanvas-end bg-dark text-white" id="dealCanvas{{$i}}" tabindex="-1" aria-labelledby="dealLabel{{$i}}">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="dealLabel{{$i}}"><strong>Deal {{$i}} Details</strong></h5>
        <!-- White cross button -->
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <img src="/images/deal{{$i}}.jpg" class="img-fluid rounded mb-3" alt="Deal {{$i}}">
        <p><strong>Extra Services:</strong> Example service description</p>
        <p><strong>Service Range:</strong> Example range info</p>
        <p><strong>Product Price:</strong> $100</p>
        <p><strong>Servicing Price:</strong> $20</p>
        <p><strong>Payment Method:</strong> Cash on Delivery / Online</p>
        <p><strong>Company Contact:</strong> 0300‑0000000</p>
        <form method="POST" action="{{ route('cart.add', $i) }}">
          @csrf
          <button type="submit" class="btn btn-warning">Grab Deal</button>
        </form>
      </div>
    </div>
  @endfor

  {{-- See More Deals Card --}}
  <div class="col">
    <div class="card luxury-card h-100 fade-up">
      <img src="/images/deals_more.jpg" class="card-img-top" alt="See More Deals">
      <div class="card-body text-center">
        <h5 class="card-title"><strong>See More Deals</strong></h5>
        <p class="card-text">Explore all available deals & services.</p>
        <a href="{{ url('/deals') }}" class="btn btn-outline-warning btn-sm">
          See More
        </a>
      </div>
    </div>
  </div>
</div>

{{-- Products Section --}}
<h2 class="mt-5 mb-3 text-center gold-text">🛒 Products</h2>
<div id="productGrid" class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
  @for($i=1; $i<=20; $i++)
  <div class="col product-card {{ $i > 8 ? 'd-none' : '' }}">
    <div class="card luxury-card h-100 fade-up">
      <img src="/images/product{{$i}}.jpg" class="card-img-top" alt="Product {{$i}}">
      <div class="card-body">
        <h5 class="card-title"><strong>Product {{$i}}</strong></h5>
        <p class="card-text">Premium renewable product with modern design.</p>
        <div class="d-flex gap-2">
          <button class="btn btn-success btn-sm" data-bs-toggle="offcanvas" data-bs-target="#productCanvas{{$i}}">
            Add to Cart
          </button>
          <button class="btn btn-warning btn-sm" data-bs-toggle="offcanvas" data-bs-target="#productCanvas{{$i}}">
            Buy Now
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- Product Offcanvas (black sidebar with white cross button) --}}
  <div class="offcanvas offcanvas-end bg-dark text-white" id="productCanvas{{$i}}" tabindex="-1" aria-labelledby="productLabel{{$i}}">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="productLabel{{$i}}"><strong>Product {{$i}}</strong></h5>
      <!-- White cross button -->
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <img src="/images/product{{$i}}.jpg" class="img-fluid mb-3">
      <p><strong>Price:</strong> $200</p>
      <p><strong>Color:</strong> Example color</p>
      <label><strong>Quantity:</strong></label>
      <input type="number" name="quantity" value="1" min="1" class="form-control w-25 mb-3">
      <p><strong>Delivery Location:</strong> Example location</p>
      <p><strong>Payment Method:</strong> Cash on Delivery / Online</p>
      <p><strong>Company Contact:</strong> 0300‑0000000</p>
      <form method="POST" action="{{ route('cart.add', $i) }}">
        @csrf
        <button type="submit" class="btn btn-success">Add to Cart</button>
        <button type="submit" class="btn btn-warning">Buy Now</button>
      </form>
    </div>
  </div>
  @endfor
</div>

<div class="text-center mt-4">
  <button id="showMoreBtn" class="btn btn-outline-light me-2">Show more</button>
  <button id="showLessBtn" class="btn btn-outline-light">Show less</button>
</div>
@endsection

@section('scripts')
<script>
  const showMoreBtn = document.getElementById('showMoreBtn');
  const showLessBtn = document.getElementById('showLessBtn');

  showMoreBtn?.addEventListener('click', () => {
    document.querySelectorAll('.product-card.d-none').forEach(el => {
      el.classList.remove('d-none');
      el.classList.add('fade-up');
    });
  });

  showLessBtn?.addEventListener('click', () => {
    document.querySelectorAll('#productGrid .product-card').forEach((el, idx) => {
      if (idx >= 8) el.classList.add('d-none');
    });
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
@endsection
