@extends('layouts.app')

@section('content')
<style>
    /* Admin Dashboard Panel Theme Custom Anchors */
    .admin-card {
        background-color: #121416 !important;
        border: 1px solid #23272a !important;
        border-radius: 10px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .admin-card:hover {
        transform: translateY(-4px);
        border-color: #d4af37 !important;
        background-color: #1a1d21 !important;
        box-shadow: 0 4px 20px rgba(212, 175, 55, 0.15);
    }
    
    /* SYSTEM-WIDE HOVER ENFORCEMENT RULES FOR BUTTONS */
    .btn-fixed-success {
        color: #ffffff !important;
        background-color: #198754 !important;
        border-color: #198754 !important;
    }
    .btn-fixed-success:hover {
        color: #ffffff !important;
        background-color: #157347 !important;
        border-color: #146c43 !important;
    }

    .btn-fixed-warning-outline {
        color: #ffc107 !important;
        background-color: transparent !important;
        border-color: #ffc107 !important;
    }
    .btn-fixed-warning-outline:hover {
        color: #000000 !important;
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
    }

    .btn-fixed-success-outline {
        color: #198754 !important;
        background-color: transparent !important;
        border-color: #198754 !important;
    }
    .btn-fixed-success-outline:hover {
        color: #ffffff !important;
        background-color: #198754 !important;
        border-color: #198754 !important;
    }

    .btn-fixed-info-outline {
        color: #0dcaf0 !important;
        background-color: transparent !important;
        border-color: #0dcaf0 !important;
    }
    .btn-fixed-info-outline:hover {
        color: #000000 !important;
        background-color: #0dcaf0 !important;
        border-color: #0dcaf0 !important;
    }

    .btn-fixed-light-outline {
        color: #ffffff !important;
        background-color: transparent !important;
        border-color: #ffffff !important;
    }
    .btn-fixed-light-outline:hover {
        color: #000000 !important;
        background-color: #ffffff !important;
        border-color: #ffffff !important;
    }

    /* Notification Feed Button Hover Fixes */
    .btn-notif-action {
        color: #ffffff !important;
        border-color: #ffffff !important;
        background-color: transparent !important;
    }
    .btn-notif-action:hover {
        color: #000000 !important;
        background-color: #ffffff !important;
        border-color: #ffffff !important;
    }

    .clear-all-link {
        color: #ffffff !important;
    }
    .clear-all-link:hover {
        color: #ffc107 !important;
        text-decoration: underline !important;
    }

    .view-all-shops-link {
        color: #d4af37 !important;
    }
    .view-all-shops-link:hover {
        color: #ffffff !important;
        text-decoration: underline !important;
    }

    .metric-number {
        font-family: 'SF Pro Display', -apple-system, sans-serif;
        font-weight: 700;
        letter-spacing: -0.5px;
    }
    .action-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="container-fluid px-2">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
        <div>
            <h1 class="fw-bold mb-1" style="color: #d4af37 !important;"><i class="fa-solid fa-screwdriver-wrench me-2"></i>Platform Command Center</h1>
            <p class="text-white small mb-0" style="color: #ffffff !important;">Overviewing system health, financial splits, vendor status, and automated marketplace notifications.</p>
        </div>
        <div>
            <span class="badge bg-danger p-2 px-3 action-badge text-white" style="color: #ffffff !important;"><i class="fa-solid fa-circle-dot me-2 animate-pulse"></i>Live Terminal</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success bg-dark text-success border-success mb-3">{{ session('success') }}</div>
    @endif

    {{-- SYSTEM COUNTERS PANEL --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card admin-card p-3 text-center h-100">
                <span class="small text-uppercase fw-semibold mb-1" style="color: #e0e0e0 !important;">Total System Users</span>
                <h3 class="metric-number my-1" style="color: #ffffff !important;">{{ $totalUsers }}</h3>
                <small class="text-success small"><i class="fa-solid fa-arrow-trend-up me-1"></i>Active accounts</small>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card admin-card p-3 text-center h-100">
                <span class="small text-uppercase fw-semibold mb-1" style="color: #e0e0e0 !important;">Total Active Shops</span>
                <h3 class="metric-number my-1" style="color: #d4af37 !important;">{{ $totalShops }}</h3>
                <small class="small" style="color: #a8aeb4 !important;">Registered Sellers</small>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card admin-card p-3 text-center h-100">
                <span class="small text-uppercase fw-semibold mb-1" style="color: #e0e0e0 !important;">Market Products</span>
                <h3 class="metric-number my-1" style="color: #ffffff !important;">{{ $totalProducts }}</h3>
                <small class="small" style="color: #a8aeb4 !important;">Hardware Inventory</small>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card admin-card p-3 text-center h-100">
                <span class="small text-uppercase fw-semibold mb-1" style="color: #e0e0e0 !important;">Active Deal Bundles</span>
                <h3 class="metric-number my-1" style="color: #ffffff !important;">{{ $totalDeals }}</h3>
                <small class="text-warning small" style="color: #ffc107 !important;">Active Promos</small>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card admin-card p-3 text-center h-100" style="border-left: 3px solid #d4af37 !important;">
                <span class="small text-uppercase fw-semibold mb-1" style="color: #e0e0e0 !important;">Commission Rate</span>
                <h3 class="metric-number my-1" style="color: #d4af37 !important;">{{ $commissionRate }}</h3>
                <small class="small" style="color: #a8aeb4 !important;">Per-transaction cut</small>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card admin-card p-3 text-center h-100" style="border-left: 3px solid #198754 !important;">
                <span class="small text-uppercase fw-semibold mb-1" style="color: #e0e0e0 !important;">Pending Commission</span>
                <h3 class="metric-number text-success my-1" style="color: #198754 !important;">Rs. {{ number_format($totalPendingCommission, 2) }}</h3>
                <small class="small" style="color: #a8aeb4 !important;">Uncollected Revenue</small>
            </div>
        </div>
    </div>

    {{-- NAVIGATION CONTROLS ROW --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <a href="{{ route('admin.products.create') }}" class="btn btn-fixed-success-outline w-100 p-2 py-3 fw-semibold small text-center d-block text-decoration-none">
                <i class="fa-solid fa-square-plus me-2"></i> Add Global Product
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.deals.create') }}" class="btn btn-fixed-warning-outline w-100 p-2 py-3 fw-semibold small text-center d-block text-decoration-none">
                <i class="fa-solid fa-tags me-2"></i> Create System Deal Bundle
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.users') }}" class="btn btn-fixed-info-outline w-100 p-2 py-3 fw-semibold small text-center d-block text-decoration-none">
                <i class="fa-solid fa-users-gear me-2"></i> Manage Users & Permissions
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.commissions') }}" class="btn btn-fixed-light-outline w-100 p-2 py-3 fw-semibold small text-center d-block text-decoration-none">
                <i class="fa-solid fa-wallet me-2"></i> Process Commission Ledger
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
        {{-- REAL-TIME ACTIVITY FEED --}}
        <div class="col-xl-4">
            <div class="card admin-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                    <h5 class="mb-0 fw-bold" style="color: #d4af37 !important;">
                        <i class="fa-solid fa-bell me-2"></i>System Notifications
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="badge bg-danger ms-1" style="font-size: 10px; color: #ffffff !important;">{{ auth()->user()->unreadNotifications->count() }} New</span>
                        @endif
                    </h5>
                    <a href="{{ route('admin.notifications.clear') }}" class="btn btn-link p-0 text-decoration-none small clear-all-link" style="font-size: 11px;">Clear All</a>
                </div>

                <div class="overflow-auto custom-scrollbar-hide" style="max-height: 380px;">
                    @forelse(auth()->user()->notifications as $notification)
                        @php
                            $notifType = $notification->data['type'] ?? 'generic';
                            $readStatus = $notification->read_at;
                            
                            $leftBorderColor = '#d4af37'; 
                            $badgeStyle = 'background-color: #ffc107 !important; color: #000000 !important;';
                            $btnText = 'View Details';
                            $btnRoute = route('admin.dashboard');
                            $btnIcon = 'fa-arrow-right';
                            $actionPhrase = 'System log update execution tracked.';

                            if ($readStatus) {
                                $leftBorderColor = '#495057';
                                $badgeStyle = 'background-color: #6c757d !important; color: #ffffff !important;';
                            }

                            switch($notifType) {
                                case 'shop_approved':
                                    if(!$readStatus) { $leftBorderColor = '#198754'; $badgeStyle = 'background-color: #198754 !important; color: #ffffff !important;'; }
                                    $btnText = 'Manage Shops'; $btnRoute = route('admin.shops'); $btnIcon = 'fa-store';
                                    $actionPhrase = 'has been successfully authorized as an active platform store node.';
                                    break;
                                    
                                case 'shop_created':
                                    if(!$readStatus) { $leftBorderColor = '#0dcaf0'; $badgeStyle = 'background-color: #0dcaf0 !important; color: #000000 !important;'; }
                                    $btnText = 'Review Shops'; $btnRoute = route('admin.shops'); $btnIcon = 'fa-store';
                                    $actionPhrase = 'has been initialized and added to the database records.';
                                    break;

                                case 'product_added':
                                    if(!$readStatus) { $leftBorderColor = '#198754'; $badgeStyle = 'background-color: #198754 !important; color: #ffffff !important;'; }
                                    $btnText = 'View Inventory'; $btnRoute = route('admin.products'); $btnIcon = 'fa-boxes-solid';
                                    $actionPhrase = 'was provisioned into marketplace items catalog.';
                                    break;

                                case 'deal_created':
                                    if(!$readStatus) { $leftBorderColor = '#ffc107'; $badgeStyle = 'background-color: #ffc107 !important; color: #000000 !important;'; }
                                    $btnText = 'Manage Deals'; $btnRoute = route('admin.deals'); $btnIcon = 'fa-tags';
                                    $actionPhrase = 'promotional bundle has been configured for display.';
                                    break;

                                case 'order_placed':
                                    if(!$readStatus) { $leftBorderColor = '#0d6efd'; $badgeStyle = 'background-color: #0d6efd !important; color: #ffffff !important;'; }
                                    $btnText = 'View Orders'; $btnRoute = route('admin.orders'); $btnIcon = 'fa-cart-shopping';
                                    $actionPhrase = 'transaction filed by customer account.';
                                    break;
                            }
                        @endphp

                        <div class="p-3 rounded mb-2 border border-secondary" style="background-color: {{ $readStatus ? '#131517' : '#1c2024' }}; border-left: 3px solid {{ $leftBorderColor }} !important;">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="badge font-monospace" style="font-size: 9px; text-transform: uppercase; {{ $badgeStyle }}">
                                    {{ str_replace('_', ' ', $notifType) }}
                                </span>
                                <small class="font-monospace" style="font-size: 10px; color: #a8aeb4 !important;">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            
                            <p class="text-white mb-1 fw-semibold" style="font-size: 13px; color: #ffffff !important;">
                                {{ $notification->data['product_name'] ?? 'System Action Configuration Log' }}
                            </p>
                            <p class="small mb-2" style="font-size: 12px; color: #e0e0e0 !important;">
                                Actor: <strong style="color: #ffffff !important;">{{ $notification->data['customer_name'] ?? 'System Engine' }}</strong> — {{ $actionPhrase }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                @if(isset($notification->data['total_price']) && $notification->data['total_price'] > 0)
                                    <span class="font-monospace small fw-bold" style="color: #198754 !important;">Rs. {{ number_format($notification->data['total_price'], 2) }}</span>
                                @else
                                    <span class="font-monospace small" style="color: #6c757d !important;">—</span>
                                @endif
                                <a href="{{ $btnRoute }}" class="btn btn-sm py-0 px-2 font-monospace btn-notif-action text-decoration-none text-center">
                                    <i class="fa-solid {{ $btnIcon }} me-1"></i>{{ $btnText }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-white">
                            <i class="fa-solid fa-envelope-open d-block fs-3 mb-2" style="color: #ffffff !important;"></i>
                            <span class="small" style="color: #a8aeb4 !important;">System Inbox Clear. No pending alerts.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- VENDOR TABLE TRACKING PANEL --}}
        <div class="col-xl-8">
            <div class="card admin-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                    <h5 class="text-white mb-0 fw-bold" style="color: #ffffff !important;"><i class="fa-solid fa-store me-2"></i>Shopkeepers & Commission Tracking</h5>
                    <a href="{{ route('admin.shops') }}" class="text-decoration-none small fw-semibold view-all-shops-link" style="font-size: 12px;">View All Shops →</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover align-middle mb-0" style="background-color: #121416 !important;">
                        <thead>
                            <tr>
                                <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;">Shop Name</th>
                                <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;">Owner</th>
                                <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;">Status</th>
                                <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;">Pending Commission</th>
                                <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shops as $shop)
                            <tr style="border-bottom: 1px solid #23272a !important;">
                                <td class="fw-semibold" style="color: #ffffff !important;">
                                    {{ $shop->name }}
                                </td>
                                <td style="color: #ffffff !important;">
                                    {{ $shop->owner->name ?? 'Unknown User' }}
                                </td>
                                <td>
                                    @if($shop->owner && $shop->owner->role === 'shopkeeper')
                                        <span class="badge bg-success text-white px-2 py-1" style="font-size: 11px;">Active Vendor</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 11px;">Pending Upgrade</span>
                                    @endif
                                </td>
                                <td class="font-monospace fw-bold" style="color: #ffc107 !important;">
                                    Rs. {{ number_format($shop->pending_commission ?? 0, 2) }}
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        @if(!$shop->owner || $shop->owner->role !== 'shopkeeper')
                                            <form action="{{ route('admin.shops.approve', $shop->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm me-1 px-2 btn-fixed-success">
                                                    <i class="fa-solid fa-check me-1"></i>Authorize
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.shops.ledger', $shop->id) }}" class="btn btn-sm px-2 btn-fixed-warning-outline text-decoration-none text-center">
                                            <i class="fa-solid fa-receipt me-1"></i>Ledger
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-white-50" style="color: #a8aeb4 !important;">
                                    No active or pending vendor profiles found in system databases.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection