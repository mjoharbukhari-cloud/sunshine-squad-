@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card bg-dark text-white border-secondary p-4" style="background-color: #121416 !important;">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-3">
            <h1 class="h3 fw-bold text-warning"><i class="fa-solid fa-store me-2"></i>Modify Shop Parameters</h1>
            <a href="{{ route('admin.shops') }}" class="btn btn-outline-light btn-sm">Back to Directory</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-dark text-success border-success mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.shops.update', $shop->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Shop Name</label>
                <input type="text" name="name" class="form-control bg-transparent text-white border-secondary" value="{{ $shop->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Physical Address Mapping</label>
                <input type="text" name="address" class="form-control bg-transparent text-white border-secondary" value="{{ $shop->address }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Description / Notes</label>
                <textarea name="description" class="form-control bg-transparent text-white border-secondary" rows="4">{{ $shop->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-warning fw-bold text-dark mt-2">
                <i class="fa-solid fa-floppy-disk me-2"></i>Apply Configuration Changes
            </button>
        </form>
    </div>
</div>
@endsection