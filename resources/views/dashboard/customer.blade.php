@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text">Customer Dashboard - {{ Auth::user()->name }}</h2>
<p>Your orders, cart, and purchases.</p>
<a href="/cart" class="btn btn-primary">View Cart</a>
<a href="/products" class="btn btn-secondary">Browse Products</a>
@endsection