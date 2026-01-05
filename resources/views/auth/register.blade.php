@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text text-center">Create Your Account</h2>

<form class="mx-auto luxury-card p-4 rounded fade-up" style="max-width: 500px;" method="POST" action="/register">
    @csrf

    {{-- Full name --}}
    <div class="mb-3">
        <label class="form-label">Full name</label>
        <input type="text" name="name" class="form-control" placeholder="John Doe" required>
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    {{-- Confirm Password --}}
    <div class="mb-3">
        <label class="form-label">Confirm password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    {{-- Role selection --}}
    <div class="mb-3">
        <label class="form-label">Role</label>
        <select class="form-select" name="role" required>
            <option value="customer">Customer</option>
            <option value="shopkeeper">Shopkeeper</option>
        </select>
    </div>

    {{-- Submit --}}
    <button class="btn btn-gold w-100">Register (demo)</button>

    <p class="text-muted mt-3 text-center">
        Already have an account? <a href="/login">Login</a>
    </p>
</form>
@endsection
