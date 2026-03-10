@extends('layouts.app')

@section('sidebar')
<div class="card mb-3">
    <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('images/default-avatar.png') }}" 
         class="card-img-top" alt="Profile Picture">
    <div class="card-body text-center">
        <h5 class="card-title">{{ Auth::user()->name }}</h5>
        <p class="card-text text-muted">{{ Auth::user()->email }}</p>
        <p class="card-text"><small>Role: {{ Auth::user()->role }}</small></p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><a href="{{ route('profile.show') }}">Profile Details</a></li>
        <li class="list-group-item"><a href="{{ route('profile.edit') }}">Edit Profile</a></li>
        @if(Auth::user()->role === 'customer')
            <li class="list-group-item"><a href="{{ route('cart.index') }}">Cart</a></li>
        @endif
        <li class="list-group-item"><a href="#">Orders</a></li>
    </ul>
</div>
@endsection

@section('content')
<div class="card p-3">
    <h3>Profile Details</h3>
    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
    <p><strong>Role:</strong> {{ Auth::user()->role }}</p>
    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a>
</div>
@endsection
