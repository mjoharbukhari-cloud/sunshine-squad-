@extends('layouts.app')

@section('content')

<h3 class="text-warning mb-4 text-uppercase">
    Category: {{ $slug }}
</h3>

@if($products->count() > 0)

<div class="row">
    @foreach($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card bg-dark text-white border-secondary">
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="card-img-top" style="height:180px; object-fit:cover;">

                <div class="card-body">
                    <h6>{{ $product->name }}</h6>
                    <p class="text-warning">Rs {{ $product->price }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

@else
    <div class="alert alert-warning">
        No products found in this category.
    </div>
@endif

@endsection