@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
<h1 style="text-align:center">Welcome To Your Dashboard</h1><br>
  {{-- Stats --}}
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card luxury-card p-3 text-center">
        <h5>Total Products</h5>
        <h2>{{ $products->count() }}</h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card luxury-card p-3 text-center">
        <h5>Total Deals</h5>
        <h2>{{ $deals->count() }}</h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card luxury-card p-3 text-center">
        <h5>Total Invested</h5>
        <h2>Rs {{ $products->sum('price') + $deals->sum('discount') }}</h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card luxury-card p-3 text-center">
        <h5>Earned Amount</h5>
        <h2>Rs {{ $shop->earnings ?? 0 }}</h2>
      </div>
    </div>
  </div>

  {{-- Add Product Button --}}
  <div class="mb-4 text-end">
    <a href="{{ route('shopkeeper.products') }}" class="btn btn-primary">Add New Product</a>
    <a href="{{ route('shopkeeper.deals') }}" class="btn btn-warning">Add New Deal</a>
  </div>

  {{-- Products Section --}}
  <h3 class="mb-3 gold-text">🛒 Products</h3>
  <div class="row">
    @foreach($products as $product)
      <div class="col-md-3">
        <div class="card mb-3 luxury-card">
          <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="card-img-top" alt="{{ $product->name }}">
          <div class="card-body text-center">
            <h5>{{ $product->name }}</h5>
            <p>{{ $product->description }}</p>
            <strong>Rs {{ $product->price }}</strong>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- Deals Section --}}
  <h3 class="mt-5 mb-3 gold-text">🔥 Deals</h3>
  <div class="row">
    @foreach($deals as $deal)
      <div class="col-md-3">
        <div class="card mb-3 luxury-card">
          <img src="{{ $deal->image ? asset('storage/'.$deal->image) : '/images/deal-placeholder.jpg' }}" class="card-img-top" alt="{{ $deal->name }}">
          <div class="card-body text-center">
            <h5>{{ $deal->name }}</h5>
            <p>{{ $deal->description }}</p>
            <strong>Discount: Rs {{ $deal->discount }}</strong>
          </div>
        </div>
      </div>
    @endforeach
  </div>

</div>
@endsection
