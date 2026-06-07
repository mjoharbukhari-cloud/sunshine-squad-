@extends('layouts.app')

@section('content')
@php
    // Determine the item and define variables to avoid null errors
    $item = $product ?? $deal;
    $isDeal = isset($deal);
@endphp

<div class="container my-5">
    <div class="row g-4">
        
        <div class="col-lg-7">
            <div class="card bg-dark text-white p-4 border border-secondary shadow-lg">
                <h3 class="mb-4 gold-text fw-bold">
                    <i class="fa-solid fa-truck-fast me-2"></i>Checkout Details
                </h3>
                
                <form action="{{ route('marketplace.placeOrder') }}" method="POST">
                    @csrf
                    
                    @if($isDeal)
                        <input type="hidden" name="deal_id" value="{{ $deal->id }}">
                    @else
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @endif

                    <input type="hidden" name="quantity" value="{{ $quantity }}">

                    <div class="mb-4">
                        <label for="delivery_address" class="form-label text-white-50 fw-semibold">
                            <i class="fa-solid fa-location-dot me-1 text-warning"></i> Delivery Address
                        </label>
                        <textarea name="delivery_address" class="form-control bg-secondary text-white border-0" rows="4" 
                            placeholder="Enter your complete delivery address (House number, Street, City, Province)" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white-50 fw-semibold d-block mb-3">
                            <i class="fa-solid fa-credit-card me-1 text-warning"></i> Select Payment Method
                        </label>
                        
                        @foreach(['cod' => 'Cash on Delivery', 'easypaisa_jazzcash' => 'EasyPaisa / JazzCash', 'card' => 'Credit/Debit Card'] as $val => $label)
                        <div class="card bg-secondary border-0 p-3 mb-2 rounded transition-hover">
                            <div class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="{{ $val }}" value="{{ $val }}" {{ $val == 'cod' ? 'checked' : '' }}>
                                <label class="form-check-label w-100 fw-bold text-white mb-0" for="{{ $val }}">
                                    {{ $label }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold text-dark mt-3 shadow">
                        <i class="fa-solid fa-circle-check me-2"></i> Confirm & Place Order Now
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card bg-dark text-white p-4 border border-secondary shadow-lg h-100">
                <h4 class="mb-4 text-white-50 fw-bold">
                    <i class="fa-solid fa-receipt me-2 gold-text"></i>Order Summary
                </h4>
                
                <div class="text-center mb-4">
                    <img src="{{ $item->image ? asset('storage/'.$item->image) : '/images/placeholder.jpg' }}" 
                         class="img-fluid rounded border border-secondary shadow mb-3" style="max-height: 200px; object-fit: cover;">
                    
                    <h5 class="fw-bold gold-text mb-1">{{ $isDeal ? $deal->title : $product->name }}</h5>
                    <p class="text-muted small px-3">{{ Str::limit($item->description, 100) }}</p>
                </div>

                <hr class="border-secondary my-3">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-white-50">Unit Price:</span>
                    <span>Rs {{ number_format($item->price, 0) }}</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-white-50">Quantity Chosen:</span>
                    <span class="badge bg-warning text-dark font-monospace">x{{ $quantity }}</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-white-50">Shipping Fee:</span>
                    <span class="text-success fw-semibold">FREE Delivery</span>
                </div>

                <hr class="border-secondary my-3">

                <div class="d-flex justify-content-between align-items-center pt-2">
                    <span class="fs-5 fw-bold text-white">Grand Total:</span>
                    <span class="fs-4 fw-bold gold-text">Rs {{ number_format($totalPrice, 0) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover { transition: transform 0.2s ease, border-color 0.2s ease; border: 1px solid transparent !important; }
    .transition-hover:hover { transform: translateY(-2px); border-color: #d4af37 !important; background-color: #242424 !important; cursor: pointer; }
</style>
@endsection