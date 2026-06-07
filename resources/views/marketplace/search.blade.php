@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text">
    <i class="fa-solid fa-magnifying-glass me-2"></i>Search Results for "{{ $query }}"
</h2>

<div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
  @forelse($products as $product)
    <div class="col product-card">
      <div class="card luxury-card h-100 fade-up">
        <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="card-img-top" alt="{{ $product->name }}">
        <div class="card-body text-center">
          <h5 class="card-title"><strong>{{ $product->name }}</strong></h5>
          <p class="card-text text-white-50">{{ Str::limit($product->description, 60) }}</p>
          <p class="gold-text fw-bold">Rs {{ $product->price }}</p>

          <div class="mt-2 d-flex justify-content-center gap-2">
            @auth
              <!-- Dynamic direct Checkout pipeline bypasses cart alerts -->
              <a href="{{ route('marketplace.buy', $product->id) }}?quantity=1" class="btn btn-warning btn-sm fw-bold">
                Buy Now
              </a>
              <button class="btn btn-outline-light btn-sm" onclick="openProductModal({{ $product->id }})">
                Details
              </button>
            @else
              <button class="btn btn-warning btn-sm" onclick="guestRedirect()">Buy Now</button>
              <button class="btn btn-outline-light btn-sm" onclick="guestRedirect()">Details</button>
            @endauth
          </div>
        </div>
      </div>
    </div>

    {{-- Info Drawer Slideout --}}
    @auth
    <div class="offcanvas offcanvas-end bg-dark text-white" id="productCanvas{{ $product->id }}" tabindex="-1">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title gold-text"><strong>{{ $product->name }}</strong></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body">
        <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="img-fluid rounded mb-3">
        <p><strong>Price:</strong> Rs {{ $product->price }}</p>
        <p><strong>Detailed Specification:</strong> {{ $product->description }}</p>
        
        <div class="d-flex gap-2 mt-4">
          <form method="POST" action="{{ route('cart.add', $product->id) }}" class="m-0 w-50">
            @csrf
            <button type="submit" class="btn btn-success w-100">Add to Cart</button>
          </form>
          <a href="{{ route('marketplace.buy', $product->id) }}?quantity=1" class="btn btn-warning w-50 fw-bold">
            Buy Now
          </a>
        </div>
      </div>
    </div>
    @endauth

  @empty
    <div class="col-12 text-center my-5 py-5">
        <div class="text-white-50 mb-3" style="font-size: 3rem;">
            <i class="fa-regular fa-folder-open"></i>
        </div>
        <h4 class="text-white">No Matching Products Found</h4>
        <p class="text-white-50">We couldn't find anything matching details for "{{ $query }}". Check your spelling or look for different items.</p>
        <a href="{{ route('marketplace.products') }}" class="btn btn-warning mt-2">Browse All Inventory</a>
    </div>
  @endforelse
</div>
@endsection

@section('scripts')
<script>
function guestRedirect() {
    alert('⚠️ Please register or log in to continue.');
    window.location.href = "{{ route('login') }}";
}

@auth
function openProductModal(id) {
    new bootstrap.Offcanvas(document.getElementById('productCanvas' + id)).show();
}
@endauth
</script>
@endsection