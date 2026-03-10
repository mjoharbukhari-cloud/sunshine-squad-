@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4 fw-bold">Shopping Cart</h2>

    @if($cartItems->count() > 0)

    <div class="row">

        {{-- Cart Items --}}
        <div class="col-lg-8">

            <div class="card shadow-sm">

                <div class="card-body">

                    <table class="table align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
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
                            $subtotal = $item->product->price * $item->quantity;
                            $total += $subtotal;
                        @endphp

                        <tr>

                            {{-- Product --}}
                            <td>

                                <div class="d-flex align-items-center">

                                    <img src="{{ asset('storage/'.$item->product->image) }}"
                                         width="70"
                                         class="rounded me-3">

                                    <div>
                                        <h6 class="mb-0">
                                            {{ $item->product->name }}
                                        </h6>

                                        <small class="text-muted">
                                            Solar Product
                                        </small>
                                    </div>

                                </div>

                            </td>

                            {{-- Price --}}
                            <td>
                                Rs {{ $item->product->price }}
                            </td>

                            {{-- Quantity --}}
                            <td>
                                {{ $item->quantity }}
                            </td>

                            {{-- Subtotal --}}
                            <td class="fw-bold">
                                Rs {{ $subtotal }}
                            </td>

                            {{-- Remove --}}
                            <td>

                                <form action="{{ route('cart.remove',$item->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        Remove
                                    </button>

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
                        <span>Rs {{ $total }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>Rs {{ $total }}</span>
                    </div>

                    <form action="{{ route('checkout.buy', $cartItems->first()->product->id) }}" method="POST">
                        @csrf

                        <button class="btn btn-success w-100 mt-4">
                            Proceed To Checkout
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    @else

    {{-- Empty Cart --}}
    <div class="text-center py-5">

        <h4>Your Cart is Empty</h4>

        <p class="text-muted">
            Browse products and add items to your cart.
        </p>

        <a href="{{ route('marketplace.products') }}"
           class="btn btn-dark">

            Browse Products

        </a>

    </div>

    @endif

</div>

@endsection