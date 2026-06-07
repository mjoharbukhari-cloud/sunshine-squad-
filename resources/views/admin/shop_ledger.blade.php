@extends('layouts.app')
@section('content')
<div class="container bg-dark text-white p-4 rounded border border-secondary mt-4">
    <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-3 mb-4">
        <div>
            <h2><i class="fa-solid fa-receipt text-warning me-2"></i>Audit Ledger: {{ $shop->name }}</h2>
            <p class="mb-0 text-white small">Owner Node User Profile: <strong>{{ $shop->owner->name ?? 'Unknown Partner' }}</strong></p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm text-white">← Return Center</a>
    </div>

    <div class="card bg-black p-4 border border-secondary">
        <h5 class="text-warning mb-3">Merchant Registry Specifications</h5>
        <ul>
            <li class="mb-2">Entity ID Code: <span class="font-monospace text-info">#{{ $shop->id }}</span></li>
            <li class="mb-2">Operational Node Status: <span class="badge bg-success">Active Authorized Node</span></li>
            <li class="mb-2">Physical Location Address Metric: <span class="text-white">{{ $shop->address ?? 'Not Specified' }}</span></li>
            <li class="mb-2">Total Uncollected Platform Commission Remittance: <span class="text-danger fw-bold font-monospace">Rs. {{ number_format($shop->pending_commission ?? 0, 2) }}</span></li>
        </ul>
    </div>
</div>
@endsection