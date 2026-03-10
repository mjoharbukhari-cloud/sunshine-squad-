@extends('layouts.app')

@section('content')
<h2 class="text-center mb-4 gold-text">All Products</h2>

<div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
  @foreach($products as $product)
    <div class="col product-card">
      <div class="card luxury-card h-100 fade-up">
        <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="card-img-top" alt="{{ $product->name }}">
        <div class="card-body">
          <h5 class="card-title"><strong>{{ $product->name }}</strong></h5>
          <p class="card-text">{{ $product->description }}</p>

          <div class="d-flex gap-2">
            <button class="btn btn-success btn-sm"
                    onclick="@guest redirectToLogin() @else openProductModal({{ $product->id }}) @endguest">
              Add to Cart
            </button>
            <button class="btn btn-warning btn-sm"
                    onclick="@guest redirectToLogin() @else openProductModal({{ $product->id }}) @endguest">
              Buy Now
            </button>
          </div>
        </div>
      </div>
    </div>

    @auth
    <div class="offcanvas offcanvas-end bg-dark text-white" id="productCanvas{{ $product->id }}" tabindex="-1">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title"><strong>{{ $product->name }}</strong></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body">
        <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="img-fluid mb-3">
        <p><strong>Price:</strong> Rs {{ $product->price }}</p>
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <form method="POST" action="{{ route('cart.add', $product->id) }}">
          @csrf
          <button type="submit" class="btn btn-success">Add to Cart</button>
          <button type="submit" class="btn btn-warning">Buy Now</button>
        </form>
      </div>
    </div>
    @endauth
  @endforeach
</div>
@endsection

@section('scripts')
<script>
function redirectToLogin() {
    alert('⚠️ Please register or log in first!');
    window.location.href = "{{ route('login') }}";
}

@auth
function openProductModal(id) {
    new bootstrap.Offcanvas(document.getElementById('productCanvas' + id)).show();
}
@endauth
</script>
@endsection
