@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text">Login</h2>
<form class="mx-auto luxury-card p-4 rounded" style="max-width: 480px;" method="POST" action="/login">
  @csrf
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
  </div>
  <div class="mb-3">
    <label class="form-label d-flex justify-content-between">
      <span>Password</span>
      <a href="#" class="text-decoration-none">Forgot?</a>
    </label>
    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
  </div>
  <button class="btn btn-primary w-100">Login</button>
  <p class="text-muted mt-3">Don’t have an account? <a href="/register">Register</a></p>
</form>
@endsection
