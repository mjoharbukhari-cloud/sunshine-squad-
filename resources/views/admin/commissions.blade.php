@extends('layouts.app')
@section('content')
<div class="container bg-dark text-white p-4 rounded border border-secondary mt-4">
    <div class="border-bottom border-secondary pb-3 mb-4">
        <h2><i class="fa-solid fa-wallet gold-text me-2"></i>Platform Commission Matrix</h2>
        <p class="text-white small mb-0">Overviewing collected cuts, current split profiles, and platform balance statements.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="p-3 rounded border border-warning UI-card match" style="background-color: #1a1d20;">
                <h6 class="text-white-50 text-uppercase small">Global Split Model Target</h6>
                <h2 class="text-warning font-monospace mb-0">10% Per Transaction</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 rounded border border-success UI-card match" style="background-color: #1a1d20;">
                <h6 class="text-white-50 text-uppercase small">Cumulative Outstanding Balances</h6>
                <h2 class="text-success font-monospace mb-0">Rs. {{ number_format($totalPendingCommission ?? 0, 2) }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection