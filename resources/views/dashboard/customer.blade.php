@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Dashboard Header --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-1">Salam, {{ Auth::user()->name }}</h2>
            <p class="text-muted mb-0">Manage your smart systems, track hardware deliveries, and browse custom IoT bundles.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end align-items-center gap-2 flex-wrap">
            
            {{-- LIVE CUSTOMER NOTIFICATION dropdown HUB --}}
            <div class="dropdown">
                <button class="btn btn-outline-dark dropdown-toggle position-relative px-3" type="button" id="customerNotificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell-fill me-1 text-warning"></i> Alerts
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end p-2 shadow border-0" aria-labelledby="customerNotificationDropdown" style="width: 320px; max-height: 400px; overflow-y: auto; border-radius: 12px;">
                    <li class="dropdown-header d-flex justify-content-between align-items-center pb-2 border-bottom">
                        <span class="fw-bold text-dark">Recent Updates</span>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <a href="{{ route('notifications.clear') }}" class="text-decoration-none small text-primary" style="font-size: 11px;">Clear All</a>
                        @endif
                    </li>
                    
                    @forelse(auth()->user()->notifications as $notification)
                        <li class="my-1">
                            <div class="p-2 rounded style-block border-start border-3 {{ $notification->read_at ? 'border-secondary bg-light' : 'border-warning bg-warning bg-opacity-10' }}">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark small text-truncate" style="max-width: 180px;">
                                        {{ $notification->data['product_name'] ?? 'Order Status Update' }}
                                    </span>
                                    <small class="text-muted font-monospace" style="font-size: 9px;">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 text-muted x-small" style="font-size: 12px; line-height: 1.4;">
                                    Your package request is being processed. Qty: {{ $notification->data['quantity'] ?? 1 }}
                                </p>
                                <span class="badge bg-dark text-white font-monospace" style="font-size: 10px;">
                                    Rs. {{ number_format($notification->data['total_price'] ?? 0) }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="text-center py-4 text-muted small">
                            <i class="bi bi-bell-slash d-block fs-4 mb-1 text-muted"></i>
                            No notifications available
                        </li>
                    @endforelse
                </ul>
            </div>

            <a href="{{ route('profile.show') }}" class="btn btn-outline-primary">
                <i class="bi bi-person-gear"></i> Settings
            </a>
            <a href="{{ route('marketplace.products') }}" class="btn btn-warning shadow-sm fw-semibold">
                <i class="bi bi-shop"></i> Open Marketplace
            </a>
        </div>
    </div>

    {{-- System Status & Operational Insights --}}
    <div class="row mb-4">
        {{-- Metric Core Cards --}}
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3 me-3">
                        <i class="bi bi-cart3 fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block text-uppercase small fw-bold">Active Cart</small>
                        <h4 class="fw-bold mb-0">{{ $cartCount ?? 0 }} Items</h4>
                        <a href="{{ route('cart.index') }}" class="small text-primary text-decoration-none">Checkout Now →</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-3 me-3">
                        <i class="bi bi-truck fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block text-uppercase small fw-bold">Dispatched Orders</small>
                        <h4 class="fw-bold mb-0">{{ $activeOrdersCount ?? 0 }} Shipping</h4>
                        <a href="#order-history" class="small text-warning text-decoration-none">Track package →</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded p-3 me-3">
                        <i class="bi bi-tools fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block text-uppercase small fw-bold">Installations</small>
                        <h4 class="fw-bold mb-0">{{ $pendingInstallationsCount ?? 1 }} Scheduled</h4>
                        <span class="small text-success">Solar/Smart System</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 text-danger rounded p-3 me-3">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block text-uppercase small fw-bold">Total Investments</small>
                        <h4 class="fw-bold mb-0">Rs {{ number_format($totalSpent ?? 45000) }}</h4>
                        <span class="small text-muted">All-time hardware investment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- System Core Split Workspaces --}}
    <div class="row">
        
        {{-- Left Major Section: Orders & System Node Deployments --}}
        <div class="col-lg-8" id="order-history">
            
            {{-- Active Package & Smart Hub Pipeline Progress Tracking --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-activity text-warning me-2"></i>Live Smart Deployment Tracking</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="p-3 bg-light rounded-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold small text-secondary">Order Reference #SS-98421</span>
                            <span class="badge bg-warning text-dark px-2.5 py-1">Processing Setup</span>
                        </div>
                        <p class="small text-muted mb-3">Item: Hybrid Solar Inverter 5KW + Smart Grid Automation Sensor Hub</p>
                        
                        {{-- Procedural Visual Progress bar --}}
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between x-small text-muted" style="font-size: 12px;">
                            <span class="text-success fw-bold">Payment Verified</span>
                            <span class="text-dark fw-bold">Assembling Hardware</span>
                            <span>Out for Delivery</span>
                            <span>Vendor Installed</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order History Matrix Ledger --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Your Order History</h5>
                    <a href="#" class="btn btn-sm btn-link text-decoration-none">See All Records</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 ps-3">Order ID</th>
                                <th class="border-0">Vendor/Shop</th>
                                <th class="border-0">Total Price</th>
                                <th class="border-0">Payment Type</th>
                                <th class="border-0">Status</th>
                                <th class="border-0 text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 fw-bold text-secondary">#SS-74102</td>
                                <td>EcoSolar Pakistan</td>
                                <td class="fw-bold text-dark">Rs 12,500</td>
                                <td><span class="badge bg-light text-dark border">COD</span></td>
                                <td><span class="badge bg-success bg-opacity-10 text-success px-2 py-1">Delivered</span></td>
                                <td class="text-end pe-3">
                                    <a href="#" class="btn btn-sm btn-outline-dark py-1 px-2">Invoice</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-bold text-secondary">#SS-73940</td>
                                <td>SmartVolt Systems</td>
                                <td class="fw-bold text-dark">Rs 32,000</td>
                                <td><span class="badge bg-light text-dark border">Bank Transfer</span></td>
                                <td><span class="badge bg-info bg-opacity-10 text-info px-2 py-1">In Route</span></td>
                                <td class="text-end pe-3">
                                    <a href="#" class="btn btn-sm btn-outline-dark py-1 px-2">Track</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Side Sidebar Column Panels: Device States & Marketplace Quick-actions --}}
        <div class="col-lg-4">
            
            {{-- Technical Vendor Integration Support Matrix --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-warning mb-2"><i class="bi bi-patch-check-fill me-2"></i>Need Smart Installation Help?</h5>
                    <p class="small text-light text-opacity-75 mb-3">All large items (Solar Arrays, Smart Breakers, Custom IoT Hubs) come with optional on-site engineer verification setup arrays.</p>
                    <a href="#" class="btn btn-warning btn-sm w-100 fw-bold shadow-sm">
                        <i class="bi bi-person-lines-fill me-1"></i> Contact Assigned Engineer
                    </a>
                </div>
            </div>

            {{-- Curated Ecosystem Smart Automation Recommendations Sidebar --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3 pb-1">
                    <h5 class="fw-bold mb-0"><i class="bi bi-lightning-charge text-danger me-2"></i>Ecosystem Add-ons</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Loop Blueprint Card Element 1 --}}
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <img src="https://via.placeholder.com/60" class="rounded me-3 border" alt="Recommended Device Model">
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 text-truncate" style="max-width: 180px;">Smart Wifi Circuit Breaker</h6>
                            <span class="text-success small fw-bold">Rs 4,200</span>
                        </div>
                        <a href="{{ route('marketplace.products') }}" class="btn btn-sm btn-outline-dark p-1 px-2">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>

                    {{-- Loop Blueprint Card Element 2 --}}
                    <div class="d-flex align-items-center">
                        <img src="https://via.placeholder.com/60" class="rounded me-3 border" alt="Recommended Device Model">
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 text-truncate" style="max-width: 180px;">Solar Panel Dust Protection Spray</h6>
                            <span class="text-success small fw-bold">Rs 1,850</span>
                        </div>
                        <a href="{{ route('marketplace.products') }}" class="btn btn-sm btn-outline-dark p-1 px-2">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection