@extends('layouts.app')

@section('content')
<h2 class="text-center mb-4">🛒 Your Orders Dashboard</h2>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card glass p-3 text-center shadow-sm">
            <h5>Total Orders</h5>
            <h3>{{ $orders->count() }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card glass p-3 text-center shadow-sm">
            <h5>Pending</h5>
            <h3>{{ $orders->where('status','pending')->count() }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card glass p-3 text-center shadow-sm">
            <h5>Delivered</h5>
            <h3>{{ $orders->where('status','delivered')->count() }}</h3>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="text-end mb-3">
    <button class="btn btn-outline-primary btn-sm" onclick="filterOrders('all')">All</button>
    <button class="btn btn-outline-warning btn-sm" onclick="filterOrders('pending')">Pending</button>
    <button class="btn btn-outline-info btn-sm" onclick="filterOrders('shipped')">Shipped</button>
    <button class="btn btn-outline-success btn-sm" onclick="filterOrders('delivered')">Delivered</button>
</div>

<div class="row g-4" id="ordersContainer">
    @forelse($orders as $order)
    <div class="col-md-6 col-lg-4 order-card" data-status="{{ $order->status }}">
        <div class="card glass h-100 p-3 shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('storage/'.$order->product->image_path) }}" class="rounded" style="width:80px; height:80px; object-fit:cover;">
                <div>
                    <h5 class="mb-1">{{ $order->product->title }}</h5>
                    <small class="badge bg-secondary">{{ $order->product->shop->name ?? 'Shop' }}</small>
                </div>
            </div>
            <hr>
            <p>{{ $order->product->description }}</p>
            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
            <p><strong>Total:</strong> ${{ $order->total_price }}</p>

            {{-- Order Status Progress --}}
            <div class="progress mb-2" style="height:8px;">
                <div class="progress-bar 
                    @if($order->status=='pending') bg-warning
                    @elseif($order->status=='shipped') bg-info
                    @else bg-success
                    @endif" 
                    style="width: {{ $order->status=='pending'?25:($order->status=='shipped'?50:100) }}%;">
                </div>
            </div>
            <p class="text-end mb-2"><small>Status: <strong>{{ ucfirst($order->status) }}</strong></small></p>
            
            <button class="btn btn-primary w-100">Track Order</button>
        </div>
    </div>
    @empty
    <div class="col-12 text-center">
        <p>No orders yet. Start shopping now!</p>
    </div>
    @endforelse
</div>
@endsection

@section('scripts')
<script>
function filterOrders(status) {
    const cards = document.querySelectorAll('.order-card');
    cards.forEach(card => {
        if(status==='all' || card.dataset.status===status){
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endsection
