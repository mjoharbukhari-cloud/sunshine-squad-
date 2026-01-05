@extends('layouts.app')

@section('content')
<h2 class="text-center mb-4 gold-text">All Products</h2>

<div id="allProducts" class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
  @for($i=1; $i<=30; $i++)
  <div class="col product-card {{ $i > 12 ? 'd-none' : '' }}">
    <div class="card luxury-card h-100 fade-up">
      <img src="/images/product{{$i}}.jpg" class="card-img-top" alt="Product {{$i}}">
      <div class="card-body">
        <h5 class="card-title"><strong>Product {{$i}}</strong></h5>
        <p class="card-text">High quality solar product.</p>

        {{-- Two buttons --}}
        <div class="d-flex gap-2">
          <button class="btn btn-success btn-sm"
                  @guest onclick="showLoginPopup()" @else data-bs-toggle="modal" data-bs-target="#productModal{{$i}}" @endguest>
            Add to Cart
          </button>
          <button class="btn btn-warning btn-sm"
                  @guest onclick="showLoginPopup()" @else data-bs-toggle="modal" data-bs-target="#productModal{{$i}}" @endguest>
            Buy Now
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- Product detail modal (only for logged in users) --}}
  @auth
  <div class="modal fade" id="productModal{{$i}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-4">
        <h4><strong>Product {{$i}}</strong></h4>
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
  </div>
  @endauth
  @endfor
</div>

<div class="text-center mt-4">
  <button id="showMoreProducts" class="btn btn-outline-light me-2">Show more</button>
  <button id="showLessProducts" class="btn btn-outline-light">Show less</button>
</div>
@endsection

@section('scripts')
<script>
  function showLoginPopup() {
    alert("⚠️ Please register or log in to buy products.");
  }

  document.getElementById('showMoreProducts')?.addEventListener('click', () => {
    document.querySelectorAll('#allProducts .product-card.d-none').forEach(el => {
      el.classList.remove('d-none');
      el.classList.add('fade-up');
    });
  });

  document.getElementById('showLessProducts')?.addEventListener('click', () => {
    document.querySelectorAll('#allProducts .product-card').forEach((el, idx) => {
      if (idx >= 12) el.classList.add('d-none');
    });
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
@endsection
