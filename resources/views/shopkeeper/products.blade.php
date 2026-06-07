@extends('layouts.app')

@section('content')
<style>
    .glass-card {
        background-color: #121416 !important;
        border: 1px solid #23272a !important;
        border-radius: 12px;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold gold-text mb-1"><i class="fa-solid fa-boxes-stacked me-2"></i>Your Products</h2>
            <p class="text-white-50 small mb-0">Manage and audit your active marketplace hardware nodes.</p>
        </div>
        <a href="{{ route('shopkeeper.products.create') }}" class="btn btn-success fw-bold px-3 py-2">
            <i class="fa-solid fa-plus me-1"></i> Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 bg-success text-white mb-4">{{ session('success') }}</div>
    @endif

    @if($products->isEmpty())
        <div class="card glass-card text-center p-5">
            <i class="fa-solid fa-box-open text-muted fs-1 mb-3"></i>
            <h5 class="text-white fw-bold">No Products Found</h5>
            <p class="text-white-50 small">Get started by adding your first smart solar device to the platform.</p>
        </div>
    @else
        <div class="row g-3">
            @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card glass-card h-100 overflow-hidden text-white">
                        <div style="height: 160px; overflow: hidden;">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" class="w-100 h-100 object-cover" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <h6 class="fw-bold text-white mb-1 text-truncate">{{ $product->name }}</h6>
                                <span class="text-success fw-bold font-monospace small d-block mb-2">Rs {{ number_format($product->price, 2) }}</span>
                                <p class="text-white-50 small mb-0" style="font-size: 12px;">Stock Available: <span class="text-white font-monospace">{{ $product->stock }}</span></p>
                            </div>
                            <div class="d-flex gap-2 mt-3 pt-2 border-top border-secondary">
                                <a href="{{ route('shopkeeper.products.edit', $product->id) }}" class="btn btn-warning btn-sm flex-grow-1 fw-bold text-dark">Edit</a>
                                <form action="{{ route('shopkeeper.products.delete', $product->id) }}" method="POST" class="d-inline flex-grow-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold" onclick="return confirm('Drop this item from store catalog?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection