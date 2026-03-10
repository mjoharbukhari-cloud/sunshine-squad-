@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4" style="max-width: 600px;">
    <h2 class="text-2xl font-bold mb-4">Create Your Shop</h2>

    @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('shop.store') }}">
        @csrf
        <div class="mb-3">
            <label class="block font-semibold">Shop Name</label>
            <input type="text" name="name" class="form-control w-full border p-2 rounded" required>
        </div>
        <div class="mb-3">
            <label class="block font-semibold">Description</label>
            <textarea name="description" class="form-control w-full border p-2 rounded"></textarea>
        </div>
        <div class="mb-3">
            <label class="block font-semibold">Address</label>
            <input type="text" name="address" class="form-control w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="btn btn-primary bg-blue-600 text-white px-4 py-2 rounded">Create Shop</button>
    </form>
</div>
@endsection
