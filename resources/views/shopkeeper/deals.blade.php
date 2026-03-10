@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="mb-4 gold-text">Your Deals</h2>

  <!-- Add New Deal Form -->
  <div class="card mb-4 luxury-card p-4">
    <h4 class="gold-text mb-3">Add New Deal</h4>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('shopkeeper.deals.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label for="title" class="form-label">Deal Title</label>
        <input type="text" name="title" id="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" name="price" id="price" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image (optional)</label>
        <input type="file" name="image" id="image" class="form-control">
      </div>
      <button type="submit" class="btn btn-warning">Add Deal</button>
    </form>
  </div>

  <!-- Existing Deals -->
  <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
    @forelse($deals as $deal)
      <div class="col">
        <div class="card luxury-card h-100 fade-up">
          <img src="{{ $deal->image ? asset('storage/'.$deal->image) : '/images/deal-placeholder.jpg' }}" class="card-img-top" alt="{{ $deal->title }}">
          <div class="card-body d-flex flex-column text-center">
            <h5 class="card-title gold-text">{{ $deal->title }}</h5>
            <p class="card-text">{{ Str::limit($deal->description, 80) }}</p>
            <h6 class="mt-2">Price: Rs {{ $deal->price }}</h6>

            <div class="mt-auto d-flex justify-content-center gap-2">
              <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#dealModal{{ $deal->id }}">View Details</button>
              <a href="{{ route('shopkeeper.deals.edit', $deal->id) }}" class="btn btn-primary btn-sm">Edit</a>
              <form action="{{ route('shopkeeper.deals.delete', $deal->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Deal Details Modal -->
      <div class="modal fade" id="dealModal{{ $deal->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content luxury-card">
            <div class="modal-header">
              <h5 class="modal-title gold-text">{{ $deal->title }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <p>{{ $deal->description }}</p>
              <hr>
              <h6>Included Products & Services:</h6>
              <ul>
                @forelse($deal->products as $product)
                  <li>{{ $product->name }} (Qty: {{ $product->pivot->quantity }})</li>
                @empty
                  <li>No products assigned yet.</li>
                @endforelse
              </ul>
              <h5 class="mt-3">Total Price: Rs {{ $deal->price }}</h5>
            </div>

            <div class="modal-footer">
              <a href="{{ route('login') }}" class="btn btn-success">Grab Deal</a>
              <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    @empty
      <p class="text-center">No deals created yet.</p>
    @endforelse
  </div>
</div>
@endsection
