@extends('layouts.app')

@section('content')
<h2 class="text-capitalize mb-3 gold-text">Category: {{ str_replace('-', ' ', $slug) }}</h2>

<div class="row">
  <div class="col-lg-3">
    <div class="luxury-card p-3 sticky-top">
      <h6 class="mb-3">Filters</h6>
      <div class="d-grid gap-2">
        <button class="btn btn-outline-light btn-sm">Price: Low to High</button>
        <button class="btn btn-outline-light btn-sm">Price: High to Low</button>
        <button class="btn btn-outline-light btn-sm">In stock</button>
        <button class="btn btn-outline-light btn-sm">Free shipping</button>
      </div>
    </div>
  </div>
  <div class="col-lg-9">
    <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
      @for($i=1; $i<=12; $i++)
      <div class="col">
        <div class="card luxury-card h-100 fade-up">
          <img src="/images/product{{$i}}.jpg" class="card-img-top" alt="Product {{$i}}">
          <div class="card-body">
            <h5 class="card-title">Product {{$i}}</h5>
            <p class="card-text">Category item description.</p>
            <div class="d-flex gap-2">
              <a href="/buy/{{$i}}" class="btn btn-gold btn-sm">Buy Now</a>
              <a href="/products" class="btn btn-outline-light btn-sm">Details</a>
            </div>
          </div>
        </div>
      </div>
      @endfor
    </div>
  </div>
</div>
@endsection
