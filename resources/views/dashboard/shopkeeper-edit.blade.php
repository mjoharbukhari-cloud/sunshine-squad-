@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 650px;">
    <div class="card bg-dark text-white border-0 shadow-lg p-4">
        
        <div class="d-flex align-items-center mb-3 border-bottom border-secondary pb-3">
            <div class="bg-warning text-dark rounded p-2.5 me-3">
                <i class="fa-solid fa-store-gear fs-4"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0 gold-text">Configure Store Profile</h4>
                <p class="text-white-50 small mb-0">Update your public marketplace details for solar & IoT consumers.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-success text-white border-0 mb-3">{{ session('success') }}</div>
        @endif

        {{-- Points directly to the ShopkeeperController update handler --}}
        <form method="POST" action="{{ route('shopkeeper.shop.update', $shop->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label small fw-bold text-uppercase tracking-wider text-white-50">Marketplace Shop Name</label>
                <input type="text" name="name" class="form-control bg-secondary bg-opacity-25 text-white border-secondary p-2.5" value="{{ $shop->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-uppercase tracking-wider text-white-50">Business Portfolio Description</label>
                <textarea name="description" rows="4" class="form-control bg-secondary bg-opacity-25 text-white border-secondary p-2.5" required>{{ $shop->description }}</textarea>
                <div class="form-text text-white-50" style="font-size: 11px;">Summarize the solar gear or smart home arrays you provide.</div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-uppercase tracking-wider text-white-50">Physical Dispatch & Warehouse Address</label>
                <input type="text" name="address" class="form-control bg-secondary bg-opacity-25 text-white border-secondary p-2.5" value="{{ $shop->address }}" required>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-2">
                <a href="{{ route('shopkeeper.dashboard') }}" class="text-white-50 small text-decoration-none">← Return to Analytics</a>
                <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">Save Configurations</button>
            </div>
        </form>
    </div>
</div>
@endsection