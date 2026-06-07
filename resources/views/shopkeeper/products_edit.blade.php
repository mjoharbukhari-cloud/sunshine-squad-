@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 650px;">
    <div class="card bg-dark text-white border-0 shadow p-4" style="border-radius:12px; background-color: #121416 !important; border: 1px solid #23272a !important;">
        <h4 class="fw-bold gold-text mb-3"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Modify Product Parameters</h4>

        <form action="{{ route('shopkeeper.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Product Title</label>
                <input type="text" name="name" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" value="{{ $product->name }}" required>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label small text-white-50 text-uppercase fw-bold">Retail Price (PKR)</label>
                    <input type="number" name="price" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" value="{{ $product->price }}" step="0.01" required>
                </div>
                <div class="col-6">
                    <label class="form-label small text-white-50 text-uppercase fw-bold">Stock Remaining</label>
                    <input type="number" name="quantity" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" value="{{ $product->stock }}" min="0" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Product Description</label>
                <textarea name="description" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" rows="4" required>{{ $product->description }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Update Inventory Image Node</label>
                <input type="file" name="image" class="form-control bg-secondary bg-opacity-10 border-secondary text-white mb-2">
                @if($product->image)
                    <div class="p-2 border border-secondary rounded d-inline-block bg-black">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="product preview" style="max-width:140px; border-radius: 6px;">
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between align-items-center pt-2">
                <a href="{{ route('shopkeeper.products') }}" class="text-white-50 small text-decoration-none">Cancel changes</a>
                <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">Save Node Metric Tweaks</button>
            </div>
        </form>
    </div>
</div>
@endsection