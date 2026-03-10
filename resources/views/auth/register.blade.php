@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text text-center">Create Your Account</h2>

<form class="mx-auto luxury-card p-4 rounded fade-up"
      style="max-width: 500px;"
      method="POST"
      action="{{ route('register') }}">
    @csrf

    {{-- Full name --}}
    <div class="mb-3">
        <label class="form-label">Full name</label>
        <input type="text" name="name" class="form-control"
               placeholder="Muhammad Ali" required>
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               placeholder="asifali@example.com" required>
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <input type="password" name="password"
                   id="password"
                   class="form-control" required>
            <button type="button" class="btn btn-outline-secondary"
                    onclick="togglePassword('password')">
                👁
            </button>
        </div>
    </div>

    {{-- Confirm Password --}}
    <div class="mb-3">
        <label class="form-label">Confirm password</label>
        <div class="input-group">
            <input type="password" name="password_confirmation"
                   id="password_confirmation"
                   class="form-control" required>
            <button type="button" class="btn btn-outline-secondary"
                    onclick="togglePassword('password_confirmation')">
                👁
            </button>
        </div>
    </div>

    {{-- Role --}}
    <div class="mb-3">
        <label class="form-label">Role</label>
        <select class="form-select" name="role" required>
            <option value="customer">Customer</option>
            <option value="shopkeeper">Shopkeeper</option>
        </select>
    </div>

    {{-- Submit --}}
    <button class="btn btn-gold w-100">Register / Sign Up</button>

    <p class="mt-3 text-center">
        Already have an account? <a href="{{ route('login') }}">Login</a>
    </p>
</form>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}
</script>
@endsection
