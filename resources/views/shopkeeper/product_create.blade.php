@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 650px;">
    <div class="card bg-dark text-white border-0 shadow p-4" style="border-radius:12px; background-color: #121416 !important; border: 1px solid #23272a !important;">
        <h4 class="fw-bold gold-text mb-3"><i class="fa-solid fa-circle-plus me-2 text-success"></i>Publish New Stock Product</h4>
        
        @if ($errors->any())
            <div class="alert alert-danger border-0 bg-danger text-white">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('shopkeeper.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Product Model Title</label>
                <input type="text" name="name" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" value="{{ old('name') }}" placeholder="e.g., Mono-Crystalline Solar Panel 550W" required>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label small text-white-50 text-uppercase fw-bold">Retail Price (PKR)</label>
                    <input type="number" name="price" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" value="{{ old('price') }}" step="0.01" placeholder="Rs" required>
                </div>
                <div class="col-6">
                    <label class="form-label small text-white-50 text-uppercase fw-bold">Warehouse Stock Units</label>
                    <input type="number" name="quantity" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" value="{{ old('quantity', 1) }}" min="1" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Specifications & Description</label>
                <textarea name="description" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" rows="4" placeholder="Detail standard operational specs, grid capabilities, warranty terms..." required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Product Showcase Display Image</label>
                <input type="file" name="image" class="form-control bg-secondary bg-opacity-10 border-secondary text-white">
            </div>

            <div class="d-flex justify-content-between align-items-center pt-2">
                <a href="{{ route('shopkeeper.products') }}" class="text-white-50 small text-decoration-none">← Discard changes</a>
                <button type="submit" class="btn btn-success px-4 fw-bold">Commit Asset to Catalog</button>
            </div>
        </form>
    </div>
</div>
@endsection