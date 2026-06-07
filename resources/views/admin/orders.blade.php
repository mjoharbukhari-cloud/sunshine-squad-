@extends('layouts.app')

@section('content')
<div class="container bg-dark text-white p-4 rounded border border-secondary mt-4" style="background-color: #121416 !important;">
    <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-3 mb-4">
        <h2 class="h4 mb-0 text-white fw-bold">
            <i class="fa-solid fa-boxes-stacked text-warning me-2"></i>Global Marketplace Orders Ledger
        </h2>
        <span class="badge bg-info text-dark fw-bold">Live Operational Logs</span>
    </div>
    
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr class="text-warning border-secondary">
                    <th>Order UUID</th>
                    <th>Customer Account</th>
                    <th>Target Node Shop</th>
                    <th>Value Total</th>
                    <th>Status Flag</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders ?? [] as $order)
                <tr class="border-secondary">
                    <td class="font-monospace text-info">#{{ $order->id }}</td>
                    
                    <td>
                        @if($order->customer)
                            <span class="fw-semibold">{{ $order->customer->name }}</span>
                            <small class="d-block text-white-50 fs-7">{{ $order->customer->email }}</small>
                        @else
                            <span class="text-white-50 italic">Direct System Client</span>
                        @endif
                    </td>
                    
                    <td>
                        @if($order->product && $order->product->shop)
                            <span class="badge bg-secondary px-2.5 py-1.5">{{ $order->product->shop->name }}</span>
                        @elseif(!empty($order->shop_name))
                            <span class="badge bg-secondary px-2.5 py-1.5">{{ $order->shop_name }}</span>
                        @else
                            <span class="badge bg-dark text-white-50 border border-secondary px-2.5 py-1.5">Marketplace General</span>
                        @endif
                    </td>
                    
                    <td class="text-success fw-bold">Rs. {{ number_format($order->total_price ?? 0, 2) }}</td>
                    
                    <td>
                        @php
                            $status = strtolower($order->status ?? 'processing');
                            $badgeClass = 'bg-warning text-dark';
                            if ($status === 'completed' || $status === 'success') {
                                $badgeClass = 'bg-success text-white';
                            } elseif ($status === 'cancelled' || $status === 'failed') {
                                $badgeClass = 'bg-danger text-white';
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }} fw-bold px-2 py-1">
                            {{ strtoupper($status) }}
                        </span>
                    </td>
                    
                    <td class="text-white-50">
                        {{ $order->created_at ? $order->created_at->format('M d, Y H:i') : 'N/A' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-white-50">
                        <i class="fa-solid fa-inbox d-block fs-3 mb-2 text-secondary"></i>
                        No customer transactional pipeline files registered in this sequence.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection