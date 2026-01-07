@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text text-center">Reset Your Password</h2>

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form class="mx-auto luxury-card p-4 rounded fade-up" style="max-width: 480px;" method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="name@example.com" value="{{ old('email') }}" required>
    </div>

    <button class="btn btn-gold w-100">Send Reset Link</button>

    <p class="text-muted mt-3 text-center">
        Remembered your password? <a href="{{ route('login') }}">Login</a>
    </p>
</form>
@endsection
