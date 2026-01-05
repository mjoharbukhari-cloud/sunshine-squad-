@extends('layouts.app')

@section('content')
<h2 class="text-center mb-4">🏢 Your Companies & Products</h2>

@foreach($shops as $company)
<div class="card glass mb-4 p-3">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h4><strong>{{ $company->name }}</strong></h4>
            <small class="text-muted">📍 {{ $company->location ?? 'No location set' }}</small>
            <p class="footer-text mt-1">☎ {{ $company->contact_number ?? 'No contact number provided' }}</p>
        </div>
        <a href="#" class="btn btn-warning">Edit Company</a>
    </div>

    <hr>

    {{-- Products Section --}}
    <h5 class="mt-3">Products</h5>
    <div class="row g-3">
        @foreach($company->products as $product)
        <div class="col-md-4">
            <div class="card h-100 p-2 product-card" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                <img src="{{ asset('storage/'.$product->image_path) }}" class="card-img-top" style="height:150px; object-fit:cover;">
                <div class="card-body">
                    <h6><strong>Product Name:</strong> {{ $product->title }}</h6>
                    <p class="mb-1"><strong>Pricing:</strong> $ {{ $product->price }}</p>
                    <p class="mb-1"><strong>Location:</strong> {{ $company->location }}</p>
                    <p class="footer-text">{{ $product->description }}</p>
                    <p class="footer-text"><strong>Payment Number:</strong> {{ $company->payment_number ?? 'N/A' }}</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-success">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Modal --}}
        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content p-4">
              <h4><strong>{{ $product->title }}</strong></h4>
              <img src="{{ asset('storage/'.$product->image_path) }}" class="img-fluid mb-3">
              <p><strong>Price:</strong> $ {{ $product->price }}</p>
              <p><strong>Color:</strong> {{ $product->color ?? 'Not specified' }}</p>
              <p><strong>Quantity:</strong> {{ $product->quantity ?? 'Available on request' }}</p>
              <p><strong>Delivery Location:</strong> {{ $company->location }}</p>
              <p><strong>Payment Method:</strong> Cash on Delivery / Online</p>
              <p><strong>Company Contact:</strong> {{ $company->payment_number ?? 'N/A' }}</p>
              <button class="btn btn-warning">Confirm Payment</button>
            </div>
          </div>
        </div>
        @endforeach

        {{-- Add Product --}}
        <div class="col-md-4">
            <div class="card h-100 d-flex justify-content-center align-items-center border border-warning">
                <a href="#" class="btn btn-outline-warning">+ Add Product</a>
            </div>
        </div>
    </div>

    {{-- Deals Section --}}
    <h5 class="mt-4">Deals</h5>
    <div class="row g-3">
        @foreach($company->deals as $deal)
        <div class="col-md-4">
            <div class="card h-100 p-2 border-warning deal-card" data-bs-toggle="modal" data-bs-target="#dealModal{{ $deal->id }}">
                <div class="card-body text-center">
                    <h6><strong>{{ $deal->title }}</strong></h6>
                    <p><strong>Extra Services:</strong> {{ $deal->description }}</p>
                    <p><strong>Service Range:</strong> {{ $deal->service_range ?? 'Not specified' }}</p>
                    <p><strong>Product Price:</strong> $ {{ $deal->product_price ?? 'N/A' }}</p>
                    <p><strong>Servicing Price:</strong> $ {{ $deal->service_price ?? 'N/A' }}</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="#" class="btn btn-sm btn-success">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Deal Modal --}}
        <div class="modal fade" id="dealModal{{ $deal->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content p-4">
              <h4><strong>{{ $deal->title }}</strong></h4>
              <p><strong>Extra Services:</strong> {{ $deal->description }}</p>
              <p><strong>Service Range:</strong> {{ $deal->service_range ?? 'Not specified' }}</p>
              <p><strong>Product Price:</strong> $ {{ $deal->product_price ?? 'N/A' }}</p>
              <p><strong>Servicing Price:</strong> $ {{ $deal->service_price ?? 'N/A' }}</p>
              <p><strong>Payment Method:</strong> Cash on Delivery / Online</p>
              <p><strong>Company Contact:</strong> {{ $company->payment_number ?? 'N/A' }}</p>
              <button class="btn btn-warning">Confirm Payment</button>
            </div>
          </div>
        </div>
        @endforeach

        {{-- Add Deal --}}
        <div class="col-md-4">
            <div class="card h-100 d-flex justify-content-center align-items-center border border-warning">
                <a href="#" class="btn btn-outline-warning">+ Add Deal</a>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
