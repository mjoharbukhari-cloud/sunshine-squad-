@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text">Edit Shop: {{ $shop->name }}</h2>
@if(session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif
<form method="POST" action="/shops/{{ $shop->id }}" class="luxury-card p-4 rounded" style="max-width: 600px;">
  @csrf
  @method('PUT')
  <div class="mb-3">
    <label class="form-label">Shop Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $shop->name) }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3" required>{{ old('description', $shop->description) }}</textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Address</label>
    <input type="text" name="address" class="form-control" value="{{ old('address', $shop->address) }}" required>
  </div>
  <button type="submit" class="btn btn-primary">Update Shop</button>
  <a href="/shops/{{ $shop->id }}" class="btn btn-secondary ms-2">Cancel</a>
</form>
@endsection