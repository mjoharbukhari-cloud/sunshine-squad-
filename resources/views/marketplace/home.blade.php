@extends('layouts.app')

@section('content')
<div class="hero text-center p-5 luxury-card rounded fade-up">
    <h1 class="fw-bold gold-text">Sunshine Squad Marketplace</h1>
    <p class="lead" style="color:#dbe3f4">Find solar products, IoT devices, and smart services.</p>
</div>

{{-- ---------------- Deals Section ---------------- --}}
<h2 class="mt-5 mb-3 text-center gold-text">Hot Deals & Services</h2>

@php
    // Prepare 3 deals
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

<div class="row row-cols-1 row-cols-sm-3 row-cols-lg-3 g-4 mb-3">
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
</div>

<div class="text-center mt-3">
    <a href="{{ route('marketplace.deals') }}" class="btn btn-warning">See More Deals</a>
</div>

{{-- ---------------- Products Section ---------------- --}}
<h2 class="mt-5 mb-3 text-center gold-text"> Featured Products</h2>

@php
    $totalProducts = isset($products) ? $products->toArray() : [];
    $dummyProducts = [];
    for ($i = 1; $i <= 20; $i++) {
        $dummyProducts[] = [
            'id' => 200 + $i,
            'name' => "Demo Product $i",
            'description' => "Sample description for demo product.",
            'price' => 50 * $i,
            'image' => "/images/product-placeholder.jpg"
        ];
    }
    $displayProducts = array_merge($totalProducts, $dummyProducts);
@endphp

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
                    
                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
                    </form>
                    <form method="POST" action="{{ route('checkout.buy', $product->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm">Buy Now</button>
                    </form>
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

</div>

<div class="text-center mt-3 mb-5">
    <button id="showMoreProducts" class="btn btn-warning">Show More Products</button>
    <button id="showLessProducts" class="btn btn-secondary d-none">Show Less Products</button>
</div>
@endsection

@section('scripts')
<script>
function guestRedirect() {
    alert('⚠️ Please register or log in to continue.');
    window.location.href = "{{ route('login') }}";
}

document.addEventListener('DOMContentLoaded', function() {
    const productContainer = document.getElementById('productContainer');
    const showMoreBtn = document.getElementById('showMoreProducts');
    const showLessBtn = document.getElementById('showLessProducts');
    const allProducts = Array.from(productContainer.children);

    const initialVisible = 8;
    let currentVisible = initialVisible;

    showMoreBtn.addEventListener('click', function() {
        currentVisible += 8;
        allProducts.forEach((el, i) => {
            el.style.display = i < currentVisible ? 'block' : 'none';
        });
        if(currentVisible >= allProducts.length){
            showMoreBtn.classList.add('d-none');
        }
        showLessBtn.classList.remove('d-none');
    });

    showLessBtn.addEventListener('click', function() {
        currentVisible -= 8;
        if(currentVisible < initialVisible) currentVisible = initialVisible;
        allProducts.forEach((el, i) => {
            el.style.display = i < currentVisible ? 'block' : 'none';
        });
        showMoreBtn.classList.remove('d-none');
        if(currentVisible === initialVisible){
            showLessBtn.classList.add('d-none');
        }
    });
});
</script>
@endsection
