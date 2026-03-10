@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="mb-4 gold-text">Create New Deal</h2>

  <form method="POST" action="{{ route('shopkeeper.deals.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label class="form-label">Deal Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Deal Description</label>
      <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>

    <!-- 🔥 THIS WAS MISSING -->
    <div class="mb-3">
      <label class="form-label">Deal Price (PKR)</label>
      <input type="number" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Deal Image (optional)</label>
      <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-warning">
      Save Deal
    </button>
  </form>
</div>
@endsection
