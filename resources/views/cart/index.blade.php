@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4 fw-bold">Shopping Cart</h2>

    @if($cartItems->count() > 0)
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th width="120">Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $total = 0; @endphp
                        @foreach($cartItems as $item)
                            @php
                                // Logic to get price/name based on type
                                $isDeal = $item->deal_id !== null;
                                $unitPrice = $isDeal ? $item->deal->price : $item->product->price;
                                $subtotal = $unitPrice * $item->quantity;
                                $total += $subtotal;
                            @endphp

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/'.($isDeal ? $item->deal->image : $item->product->image)) }}"
                                             width="70" class="rounded me-3">
                                        <div>
                                            <h6 class="mb-0">{{ $isDeal ? $item->deal->title : $item->product->name }}</h6>
                                            <small class="text-muted">{{ $isDeal ? 'Special Deal' : 'Solar Product' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rs {{ number_format($unitPrice, 0) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-bold">Rs {{ number_format($subtotal, 0) }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>Rs {{ number_format($total, 0) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>Rs {{ number_format($total, 0) }}</span>
                    </div>

                    {{-- Dynamic Checkout Button --}}
                    @if($cartItems->count() === 1 && $cartItems->first()->deal_id)
                        <a href="{{ route('marketplace.buy', 0) }}?deal_id={{ $cartItems->first()->deal_id }}&quantity={{ $cartItems->first()->quantity }}" 
                           class="btn btn-success w-100 mt-4">Proceed To Checkout</a>
                    @else
                        <a href="{{ route('marketplace.buy', $cartItems->first()->product_id ?? 0) }}" 
                           class="btn btn-success w-100 mt-4">Proceed To Checkout</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="text-center py-5">
            <h4>Your Cart is Empty</h4>
            <a href="{{ route('marketplace.products') }}" class="btn btn-dark">Browse Products</a>
        </div>
    @endif
</div>

@endsection