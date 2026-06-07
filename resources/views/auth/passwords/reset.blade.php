@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text text-center">Set New Password</h2>

<form class="mx-auto luxury-card p-4 rounded fade-up" style="max-width: 480px;" method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button class="btn btn-gold w-100">Reset Password</button>

    <p class="text-muted mt-3 text-center">
        Back to <a href="{{ route('login') }}">Login</a>
    </p>
</form>
@endsection
