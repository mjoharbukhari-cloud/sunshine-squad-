@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text text-center">Login to Your Account</h2>

@if ($errors->any())
  <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
      <p>{{ $error }}</p>
    @endforeach
  </div>
@endif

<form class="mx-auto luxury-card p-4 rounded fade-up" style="max-width: 480px;" method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Email --}}
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="name@example.com" value="{{ old('email') }}" required>
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label class="form-label d-flex justify-content-between">
            <span>Password</span>
            <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot?</a>
        </label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
    </div>

    {{-- Submit Button --}}
    <button class="btn btn-gold w-100">Login</button>

    {{-- Register Link --}}
    <p class="text-muted mt-3 text-center">
        Don’t have an account? <a href="{{ route('register') }}">Register</a>
    </p>
</form>
@endsection
