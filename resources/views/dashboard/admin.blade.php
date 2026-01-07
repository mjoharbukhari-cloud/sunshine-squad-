@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text">Admin Dashboard - {{ Auth::user()->name }}</h2>
<p>Full control over the marketplace.</p>
<div class="row">
  <div class="col-md-3"><a href="/admin/shops" class="btn btn-primary w-100">Manage Shops</a></div>
  <div class="col-md-3"><a href="/admin/products/all" class="btn btn-secondary w-100">Manage Products</a></div>
  <div class="col-md-3"><a href="/admin/deals" class="btn btn-warning w-100">Approve Deals</a></div>
  <div class="col-md-3"><a href="/admin/users" class="btn btn-danger w-100">Manage Users</a></div>
</div>
@endsection