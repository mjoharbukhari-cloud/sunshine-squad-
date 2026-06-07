@extends('layouts.app')

@section('content')
<style>
    .glass-card {
        background-color: #121416 !important;
        border: 1px solid #23272a !important;
        border-radius: 12px;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold gold-text mb-1"><i class="fa-solid fa-bolt me-2 text-warning"></i>Promo Bundle Packages</h2>
            <p class="text-white-50 small mb-0">Create and monitor value bundles to attract customers.</p>
        </div>
        <a href="{{ route('shopkeeper.deals.create') }}" class="btn btn-warning fw-bold text-dark px-3 py-2">
            <i class="fa-solid fa-circle-plus me-1"></i> Configure Bundle
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 bg-success text-white mb-4">{{ session('success') }}</div>
    @endif

    @if($deals->isEmpty())
        <div class="card glass-card text-center p-5">
            <i class="fa-solid fa-tags text-muted fs-1 mb-3"></i>
            <h5 class="text-white fw-bold">No Custom Deals Created</h5>
            <p class="text-white-50 small">Bundle together products and services to launch high-conversion promo items.</p>
        </div>
    @else
        <div class="row g-3">
            @foreach($deals as $deal)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card glass-card h-100 overflow-hidden text-white">
                        <div style="height: 150px; overflow: hidden;">
                            <img src="{{ $deal->image ? asset('storage/'.$deal->image) : '/images/deal-placeholder.jpg' }}" class="w-100 h-100 object-cover" alt="{{ $deal->title }}">
                        </div>
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <h6 class="fw-bold text-warning mb-1 text-truncate">{{ $deal->title }}</h6>
                                <p class="text-white-50 x-small mb-2" style="font-size:12px; line-height: 1.3;">{{ Str::limit($deal->description, 60) }}</p>
                                <span class="text-white fw-bold font-monospace small d-block">Rs {{ number_format($deal->price, 2) }}</span>
                            </div>
                            <div class="d-flex gap-2 mt-3 pt-2 border-top border-secondary">
                                <a href="{{ route('shopkeeper.deals.edit', $deal->id) }}" class="btn btn-outline-warning btn-sm flex-grow-1 fw-bold">Edit</a>
                                <form action="{{ route('shopkeeper.deals.delete', $deal->id) }}" method="POST" class="d-inline flex-grow-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold" onclick="return confirm('Delete this custom bundle option permanently?')">Drop</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection