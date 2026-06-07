@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 650px;">
    <div class="card bg-dark text-white border-0 shadow p-4" style="border-radius:12px; background-color: #121416 !important; border: 1px solid #23272a !important;">
        <h4 class="fw-bold gold-text mb-3"><i class="fa-solid fa-bolt me-2 text-warning"></i>Launch Premium Package Bundle</h4>

        <form method="POST" action="{{ route('shopkeeper.deals.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Promo Bundle Title</label>
                <input type="text" name="title" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" placeholder="e.g., 5KW Complete Hybrid Setup Deal" required>
            </div>

            <div class="mb-3">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Bundle Package Overview Description</label>
                <textarea name="description" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" rows="4" placeholder="Detail everything included, structural equipment, inverter types, and free setup windows..." required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label small text-white-50 text-uppercase fw-bold">All-Inclusive Deal Price (PKR)</label>
                <input type="number" name="price" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" placeholder="Rs" required>
            </div>

            <div class="mb-4">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Bundle Promotional Banner Graphic</label>
                <input type="file" name="image" class="form-control bg-secondary bg-opacity-10 border-secondary text-white">
            </div>

            <div class="d-flex justify-content-between align-items-center pt-2">
                <a href="{{ route('shopkeeper.deals') }}" class="text-white-50 small text-decoration-none">← Go Back</a>
                <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">Save Promotional Bundle</button>
            </div>
        </form>
    </div>
</div>
@endsection