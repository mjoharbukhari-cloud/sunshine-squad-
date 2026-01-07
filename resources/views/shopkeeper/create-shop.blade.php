@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text">Create a New Shop</h2>
@if(session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif
<form method="POST" action="/shops" class="luxury-card p-4 rounded" style="max-width: 600px;">
  @csrf
  <div class="mb-3">
    <label class="form-label">Shop Name</label>
    <input type="text" name="name" class="form-control" placeholder="e.g., Sunshine Solar Shop" value="{{ old('name') }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3" placeholder="Describe your shop" required>{{ old('description') }}</textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Address</label>
    <input type="text" name="address" class="form-control" placeholder="e.g., 123 Solar Street, City" value="{{ old('address') }}" required>
  </div>
  <button type="submit" class="btn btn-primary">Create Shop</button>
  <a href="/shops" class="btn btn-secondary ms-2">Back to Shops</a>
</form>
@endsection