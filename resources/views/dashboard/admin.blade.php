@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row g-3">

        <div class="col-md-3">
            <a href="{{ route('admin.products') }}" class="btn btn-success w-100 p-3">
                ➕ Add Product
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.deals') }}" class="btn btn-warning w-100 p-3">
                ➕ Add Deal
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.products') }}" class="btn btn-primary w-100 p-3">
                📦 View Products
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.deals') }}" class="btn btn-danger w-100 p-3">
                🔥 View Deals
            </a>
        </div>

    </div>

    <hr class="my-4">

    <div class="row text-center">
        <div class="col-md-4">
            <div class="card p-3">
                <h4>Total Users</h4>
                <h2>{{ $totalUsers }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4>Total Products</h4>
                <h2>{{ $totalProducts }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4>Total Deals</h4>
                <h2>{{ $totalDeals }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection
