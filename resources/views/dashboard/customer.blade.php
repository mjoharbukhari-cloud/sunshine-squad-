@extends('layouts.app')

@section('content')

<div class="container">

    {{-- Dashboard Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold text-warning">{{ Auth::user()->name }} </h2>
             <p class=" mt-1">
                <strong>Welcome back To Your Dashboard </strong>
            </p>
        </div>

        <a href="{{ route('profile.show') }}" class="btn btn-outline-dark">
            My Profile
        </a>

    </div>


    {{-- Dashboard Stats --}}
    <div class="row mb-5">

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-center p-4">
                <h5>Cart Items</h5>
                <h3 class="text-primary">{{ $cartCount }}</h3>
                <a href="{{ route('cart.index') }}" class="btn btn-sm btn-primary mt-2">
                    View Cart
                </a>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-center p-4">
                <h5>Browse Products</h5>
                <p class="text-muted">Explore Different Electronic products</p>
                <a href="{{ route('marketplace.products') }}" class="btn btn-sm btn-success">
                    Browse Products
                </a>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-center p-4">
                <h5>Hot Deals</h5>
                <p class="text-muted">View bundle offers</p>
                <a href="{{ route('marketplace.deals') }}" class="btn btn-sm btn-warning">
                    View Deals
                </a>
            </div>
        </div>

    </div>


    <!-- {{-- Latest Products --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4>Latest Products</h4>

        <a href="{{ route('marketplace.products') }}" class="btn btn-sm btn-outline-dark">
            View All
        </a>

    </div>

    <div class="row">

        @forelse($products as $product)

        <div class="col-md-4 mb-4">

            <div class="card h-100 shadow-sm">

                <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/300' }}"
                     class="card-img-top">

                <div class="card-body">

                    <h5 class="card-title">{{ $product->name }}</h5>

                    <p class="text-success fw-bold">
                        Rs {{ $product->price }}
                    </p>

                    <p class="small text-muted">
                        {{ Str::limit($product->description,80) }}
                    </p>

                    <form method="POST" action="{{ route('cart.add',$product->id) }}">
                        @csrf
                        <button class="btn btn-dark btn-sm">
                            Add To Cart
                        </button>
                    </form>

                </div>

            </div>

        </div>

        @empty

        <p>No products available.</p>

        @endforelse

    </div>


    {{-- Latest Deals --}}
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">

        <h4>Hot Deals</h4>

        <a href="{{ route('marketplace.deals') }}" class="btn btn-sm btn-outline-dark">
            View All Deals
        </a>

    </div>

    <div class="row">

        @forelse($deals as $deal)

        <div class="col-md-3 mb-4">

            <div class="card h-100 shadow-sm">

                <img src="{{ $deal->image ? asset('storage/'.$deal->image) : 'https://via.placeholder.com/300' }}"
                     class="card-img-top">

                <div class="card-body">

                    <h5 class="card-title">{{ $deal->title }}</h5>

                    <p class="text-danger fw-bold">
                        Rs {{ $deal->price }}
                    </p>

                    <p class="small text-muted">
                        {{ Str::limit($deal->description,80) }}
                    </p>

                    <a href="{{ route('marketplace.deals.show',$deal->id) }}"
                       class="btn btn-outline-dark btn-sm">

                        View Deal
                    </a>

                </div>

            </div>

        </div>

        @empty

        <p>No deals available.</p>

        @endforelse

    </div>

</div> -->

@endsection