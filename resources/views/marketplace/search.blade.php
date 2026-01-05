@extends('layouts.app')

@section('content')
@php $empty = empty($query); @endphp
<h2 class="mb-4 gold-text">{{ $empty ? 'All products' : 'Search results for "'.$query.'"' }}</h2>

<div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
  @for($i=1; $i<=($empty ? 16 : 8); $i++)
  <div class="col">
    <div class="card luxury-card h-100 fade-up">
      <img src="/images/product{{$i}}.jpg" class="card-img-top" alt="Product {{$i}}">
      <div class="card-body">
        <h5 class="card-title">Product {{$i}}</h5>
        <p class="card-text">{{ $empty ? 'Browse all products.' : 'Matched your search.' }}</p>
        <div class="d-flex gap-2">
          <a href="/buy/{{$i}}" class="btn btn-gold btn-sm">Buy Now</a>
          <a href="/products" class="btn btn-outline-light btn-sm">Details</a>
        </div>
      </div>
    </div>
  </div>
  @endfor
</div>
@endsection
