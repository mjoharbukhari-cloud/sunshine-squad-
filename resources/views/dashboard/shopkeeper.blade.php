@extends('layouts.app')

@section('content')
<style>
    /* Shopkeeper Premium Custom UI Elements */
    .vendor-card {
        background-color: #121416 !important;
        border: 1px solid #23272a !important;
        border-radius: 10px;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }
    .vendor-card:hover {
        transform: translateY(-2px);
        border-color: #d4af37 !important;
    }
    .metric-val {
        font-family: 'SF Pro Display', -apple-system, sans-serif;
        font-weight: 700;
    }
    .product-img-container {
        height: 160px;
        overflow: hidden;
        position: relative;
        border-top-left-radius: 9px;
        border-top-right-radius: 9px;
    }
    .product-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .status-tag {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .table-custom-vendor {
        background-color: #121416 !important;
        color: #eaeaea !important;
        border: 1px solid #23272a;
    }
    .table-custom-vendor th {
        background-color: #1a1d20 !important;
        color: #d4af37 !important;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #2d3238;
    }
    .table-custom-vendor td {
        border-bottom: 1px solid #23272a;
        vertical-align: middle;
        font-size: 13.5px;
    }
    .gold-text {
        color: #d4af37 !important;
    }
</style>

<div class="container-fluid px-3 py-4">

    {{-- TOP DASHBOARD TITLE & ACTION LAYER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
        <div>
            <h1 class="fw-bold gold-text mb-1">
                <i class="fa-solid fa-store me-2"></i>{{ $shop->name ?? 'Vendor Hub' }}
            </h1>
            <p class="text-white-50 small mb-0">Manage your stock, process incoming solar/IoT orders, and monitor your commission status.</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            
            {{-- LIVE SHOPKEEPER NOTIFICATION DROPDOWN --}}
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm position-relative px-3 py-2" type="button" id="vendorNotificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bell gold-text me-1"></i> Alerts
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 9px;">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end p-2 shadow border-0 bg-dark" aria-labelledby="vendorNotificationDropdown" style="width: 320px; max-height: 400px; overflow-y: auto; border: 1px solid #23272a !important; border-radius: 12px;">
                    <li class="dropdown-header d-flex justify-content-between align-items-center pb-2 border-bottom border-secondary">
                        <span class="fw-bold text-white">Store Orders Alert</span>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <a href="{{ route('notifications.clear') }}" class="text-decoration-none small gold-text" style="font-size: 11px;">Clear All</a>
                        @endif
                    </li>
                    
                    @forelse(auth()->user()->notifications as $notification)
                        <li class="my-1">
                            <div class="p-2 rounded border-start border-3 {{ $notification->read_at ? 'border-secondary bg-secondary bg-opacity-10 text-white-50' : 'border-warning bg-warning bg-opacity-10 text-white' }}">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold small text-truncate" style="max-width: 170px;">
                                        {{ $notification->data['product_name'] ?? 'New Order Assigned' }}
                                    </span>
                                    <small class="text-muted" style="font-size: 9px;">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 text-white-50 x-small" style="font-size: 12px; line-height: 1.4;">
                                    Fulfillment requested for Qty: {{ $notification->data['quantity'] ?? 1 }}
                                </p>
                                <span class="badge bg-light text-dark font-monospace" style="font-size: 10px;">
                                    Rs. {{ number_format($notification->data['total_price'] ?? 0) }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="text-center py-4 text-white-50 small">
                            <i class="fa-solid fa-bell-slash d-block fs-4 mb-2 text-muted"></i>
                            No marketplace alerts found
                        </li>
                    @endforelse
                </ul>
            </div>

            <a href="{{ route('shopkeeper.products') }}" class="btn btn-success btn-sm px-3 fw-semibold py-2">
                <i class="fa-solid fa-circle-plus me-1"></i> Add Product
            </a>
            <a href="{{ route('shopkeeper.deals') }}" class="btn btn-warning btn-sm px-3 fw-semibold py-2 text-dark">
                <i class="fa-solid fa-bolt me-1"></i> Add Bundle Deal
            </a>
        </div>
    </div>

    {{-- SYSTEM COUNTER STATS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card vendor-card p-3 text-center h-100">
                <span class="text-muted small text-uppercase fw-semibold mb-1">Active Products</span>
                <h3 class="metric-val text-white my-1">{{ $products->count() }}</h3>
                <small class="text-white-50 small">Catalog Items</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card vendor-card p-3 text-center h-100">
                <span class="text-muted small text-uppercase fw-semibold mb-1">Active Deals</span>
                <h3 class="metric-val text-white my-1">{{ $deals->count() }}</h3>
                <small class="text-warning small">Promo Bundles</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card vendor-card p-3 text-center h-100" style="border-left: 3px solid #198754 !important;">
                <span class="text-muted small text-uppercase fw-semibold mb-1">Your Earnings</span>
                <h3 class="metric-val text-success my-1">Rs {{ number_format($shop->earnings ?? 0, 2) }}</h3>
                <small class="text-white-50 small">Withdrawn/Available</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card vendor-card p-3 text-center h-100" style="border-left: 3px solid #d4af37 !important;">
                <span class="text-muted small text-uppercase fw-semibold mb-1">Pending Commission</span>
                <h3 class="metric-val text-warning my-1">Rs {{ number_format($shop->pending_commission ?? 0, 2) }}</h3>
                <small class="text-muted small">Platform 10% Cut</small>
            </div>
        </div>
    </div>

    {{-- INCOMING RECENT ORDERS MANAGEMENT --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card vendor-card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                    <h5 class="text-white mb-0 fw-bold"><i class="fa-solid fa-receipt text-warning me-2"></i>Incoming Orders Requiring Fulfillment</h5>
                    <span class="badge bg-danger rounded-pill px-2.5" style="font-size: 11px;">Action Required</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-custom-vendor align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Item Details</th>
                                <th>Customer Billing</th>
                                <th>Earning Split</th>
                                <th>Order Status</th>
                                <th class="text-end">Update Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($incomingOrders ?? [] as $orderItem)
                            <tr>
                                <td class="font-monospace text-white fw-bold">#SS-{{ $orderItem->order_id }}</td>
                                <td>
                                    <span class="text-white d-block fw-semibold">{{ $orderItem->product->name }}</span>
                                    <small class="text-muted">Qty: {{ $orderItem->quantity }}</small>
                                </td>
                                <td>
                                    <span class="small d-block text-white-50">{{ $orderItem->order->shipping_address ?? 'Direct Delivery' }}</span>
                                </td>
                                <td class="text-success font-monospace fw-bold">Rs {{ number_format($orderItem->price * $orderItem->quantity, 2) }}</td>
                                <td>
                                    @if($orderItem->status === 'pending')
                                        <span class="badge bg-warning text-dark px-2 py-1 small">Pending</span>
                                    @elseif($orderItem->status === 'shipped')
                                        <span class="badge bg-info text-white px-2 py-1 small">Shipped</span>
                                    @else
                                        <span class="badge bg-success text-white px-2 py-1 small">Delivered</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form action="/shopkeeper/order-item/{{ $orderItem->id }}/update-status" method="POST" class="d-inline">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline-block w-auto bg-dark text-white border-secondary" style="font-size: 12px;">
                                            <option value="pending" {{ $orderItem->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="shipped" {{ $orderItem->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $orderItem->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-white-50 small">
                                    <i class="fa-solid fa-box-open d-block fs-4 mb-2 text-muted"></i> No client purchase orders assigned to your shop listings yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- VENDOR PRODUCTS CATALOG INDEX --}}
    <div class="d-flex align-items-center mb-3 border-bottom border-secondary pb-2">
        <h4 class="fw-bold gold-text mb-0"><i class="fa-solid fa-boxes-stacked me-2"></i>Your Registered Marketplace Inventory</h4>
    </div>
    <div class="row g-3 mb-5">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card vendor-card h-100 overflow-hidden">
                    <div class="product-img-container">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/product-placeholder.jpg' }}" alt="{{ $product->name }}">
                        @if($product->approved)
                            <span class="status-tag bg-success text-white"><i class="fa-solid fa-circle-check me-1"></i>Approved</span>
                        @else
                            <span class="status-tag bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i>Reviewing</span>
                        @endif
                    </div>
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <h6 class="fw-bold text-white mb-1 text-truncate">{{ $product->name }}</h6>
                            <p class="text-white-50 x-small mb-2" style="font-size: 12px; line-height:1.4;">{{ Str::limit($product->description, 60) }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-secondary">
                            <span class="text-success fw-bold font-monospace small">Rs {{ number_format($product->price) }}</span>
                            <a href="/shopkeeper/products/{{ $product->id }}/edit" class="btn btn-link text-muted p-0 text-decoration-none x-small" style="font-size: 12px;"><i class="fa-solid fa-pen-to-square me-1"></i>Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-white-50 small ps-3">No custom products found linked to this shop profile.</p>
        @endforelse
    </div>

    {{-- VENDOR CUSTOM PACKAGE BUNDLES INDEX --}}
    <div class="d-flex align-items-center mb-3 border-bottom border-secondary pb-2">
        <h4 class="fw-bold gold-text mb-0"><i class="fa-solid fa-tags me-2"></i>Your Configured Bundle Deals</h4>
    </div>
    <div class="row g-3 mb-4">
        @forelse($deals as $deal)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card vendor-card h-100 overflow-hidden">
                    <div class="product-img-container">
                        <img src="{{ $deal->image ? asset('storage/'.$deal->image) : '/images/deal-placeholder.jpg' }}" alt="{{ $deal->title }}">
                        @if($deal->approved)
                            <span class="status-tag bg-success text-white"><i class="fa-solid fa-circle-check me-1"></i>Approved</span>
                        @else
                            <span class="status-tag bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i>Reviewing</span>
                        @endif
                    </div>
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <h6 class="fw-bold text-white mb-1 text-truncate">{{ $deal->title }}</h6>
                            <p class="text-white-50 x-small mb-2" style="font-size: 12px; line-height:1.4;">{{ Str::limit($deal->description, 60) }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-secondary">
                            <span class="text-danger fw-bold font-monospace small">Rs {{ number_format($deal->price) }}</span>
                            <a href="/shopkeeper/deals/{{ $deal->id }}/edit" class="btn btn-link text-muted p-0 text-decoration-none x-small" style="font-size: 12px;"><i class="fa-solid fa-pen-to-square me-1"></i>Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-white-50 small ps-3">No promotional package bundles launched yet.</p>
        @endforelse
    </div>

</div>
@endsection