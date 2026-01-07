@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text">Shopkeeper Dashboard - {{ Auth::user()->name }}</h2>
<p>Manage your shops, products, and deals.</p>
<div class="row">
  <div class="col-md-4"><a href="/shops" class="btn btn-primary w-100">My Shops</a></div>
  <div class="col-md-4"><a href="/products/create" class="btn btn-secondary w-100">Add Product</a></div>
  <div class="col-md-4"><a href="/deals/create" class="btn btn-warning w-100">Add Deal</a></div>
</div>
@endsection