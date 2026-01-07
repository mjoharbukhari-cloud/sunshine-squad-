@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text">{{ $shop->name }}</h2>
<div class="luxury-card p-4 rounded">
  <p><strong>Description:</strong> {{ $shop->description }}</p>
  <p><strong>Address:</strong> {{ $shop->address }}</p>
  <p><strong>Created:</strong> {{ $shop->created_at->format('M d, Y') }}</p>
  <a href="/shops/{{ $shop->id }}/edit" class="btn btn-warning">Edit</a>
  <a href="/shops" class="btn btn-secondary">Back to Shops</a>
</div>
@endsection