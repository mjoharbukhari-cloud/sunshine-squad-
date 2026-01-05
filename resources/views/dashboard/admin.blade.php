@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text">Admin dashboard</h2>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card luxury-card h-100 fade-up">
            <div class="card-body">
                <h5 class="card-title">Pending products</h5>
                <p class="card-text">Approve or reject listings.</p>
                <a href="#" class="btn btn-gold btn-sm">Review products</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card luxury-card h-100 fade-up">
            <div class="card-body">
                <h5 class="card-title">Pending deals</h5>
                <p class="card-text">Moderate promotions.</p>
                <a href="#" class="btn btn-outline-light btn-sm">Review deals</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card luxury-card h-100 fade-up">
            <div class="card-body">
                <h5 class="card-title">Categories</h5>
                <p class="card-text">Manage catalog and hierarchy.</p>
                <a href="#" class="btn btn-outline-light btn-sm">Manage categories</a>
            </div>
        </div>
    </div>
</div>
@endsection
