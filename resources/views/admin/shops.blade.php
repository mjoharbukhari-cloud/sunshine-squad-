@extends('layouts.app')

@section('content')
<style>
    .shops-container {
        background-color: #121416 !important;
        border: 1px solid #23272a !important;
        border-radius: 10px;
    }

    /* FORCED INLINE HOVER MATRIX FOR INDIVIDUAL ACTION ENGINES */
    .btn-action-success {
        color: #ffffff !important;
        background-color: #198754 !important;
        border-color: #198754 !important;
    }
    .btn-action-success:hover {
        color: #ffffff !important;
        background-color: #157347 !important;
        border-color: #146c43 !important;
    }

    .btn-action-warning-outline {
        color: #ffc107 !important;
        background-color: transparent !important;
        border-color: #ffc107 !important;
    }
    .btn-action-warning-outline:hover {
        color: #000000 !important;
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
    }

    .btn-action-info-outline {
        color: #0dcaf0 !important;
        background-color: transparent !important;
        border-color: #0dcaf0 !important;
    }
    .btn-action-info-outline:hover {
        color: #000000 !important;
        background-color: #0dcaf0 !important;
        border-color: #0dcaf0 !important;
    }

    .btn-action-danger-outline {
        color: #dc3545 !important;
        background-color: transparent !important;
        border-color: #dc3545 !important;
    }
    .btn-action-danger-outline:hover {
        color: #ffffff !important;
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

    .btn-action-back-outline {
        color: #ffffff !important;
        background-color: transparent !important;
        border-color: #ffffff !important;
    }
    .btn-action-back-outline:hover {
        color: #000000 !important;
        background-color: #ffffff !important;
        border-color: #ffffff !important;
    }
</style>

<div class="container bg-dark text-white p-4 rounded border border-secondary mt-4 shops-container">
    <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-3 mb-4">
        <h2 class="h4 mb-0 fw-bold" style="color: #ffffff !important;">
            <i class="fa-solid fa-store text-warning me-2" style="color: #ffc107 !important;"></i>Marketplace Registered Shops Database
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-action-back-outline text-decoration-none text-center">
            <i class="fa-solid fa-arrow-left me-1"></i> Command Hub
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success bg-dark text-success border-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover align-middle mb-0" style="background-color: #121416 !important;">
            <thead>
                <tr class="border-secondary">
                    <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;">ID</th>
                    <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;">Shop Identity Profile</th>
                    <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;">Owner Contact Name</th>
                    <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;">Status State</th>
                    <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;">Pending Ledger</th>
                    <th style="color: #d4af37 !important; background-color: #1a1d20 !important; font-size: 12px; text-transform: uppercase;" class="text-center">Control Operations Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shops ?? [] as $shop)
                <tr class="border-secondary">
                    <!-- ID Column -->
                    <td class="font-monospace text-info" style="color: #0dcaf0 !important;">#{{ $shop->id }}</td>
                    
                    <!-- Shop Metadata Column -->
                    <td>
                        <span class="fw-bold d-block" style="color: #ffffff !important; font-size: 15px;">{{ $shop->name }}</span>
                        @if(!empty($shop->address))
                            <small class="text-muted d-block mt-0.5"><i class="fa-solid fa-location-dot me-1"></i>{{ $shop->address }}</small>
                        @endif
                    </td>

                    <!-- Owner Column -->
                    <td style="color: #ffffff !important;">
                        <span class="d-block fw-semibold">{{ $shop->owner->name ?? 'System Guest Client' }}</span>
                        <small class="text-white-50 fs-7 d-block" style="color: #a8aeb4 !important;">{{ $shop->owner->email ?? 'no-email@linked' }}</small>
                    </td>

                    <!-- Status Column -->
                    <td>
                        @if($shop->owner && $shop->owner->role === 'shopkeeper')
                            <span class="badge bg-success text-white px-2.5 py-1.5 fw-bold" style="font-size: 10px; text-transform: uppercase;">AUTHORIZED VENDOR</span>
                        @else
                            <span class="badge bg-warning text-dark px-2.5 py-1.5 fw-bold" style="font-size: 10px; text-transform: uppercase;">UPGRADE REQUIRED</span>
                        @endif
                    </td>

                    <!-- Financial Ledger Column -->
                    <td class="fw-bold" style="color: #ffc107 !important;">
                        Rs. {{ number_format($shop->pending_commission ?? 0, 2) }}
                    </td>

                    <!-- Operation Actions Controls Column -->
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <!-- Authorization Form Conditional Node -->
                            @if(!$shop->owner || $shop->owner->role !== 'shopkeeper')
                                <form action="{{ route('admin.shops.approve', $shop->id) }}" method="POST" class="d-inline mb-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-action-success px-2.5 fw-semibold">
                                        <i class="fa-solid fa-circle-check me-1"></i>Authorize Merchant
                                    </button>
                                </form>
                            @endif

                            <!-- Ledger Anchor Router link -->
                            <a href="{{ route('admin.shops.ledger', $shop->id) }}" class="btn btn-sm btn-action-warning-outline px-2.5 fw-semibold text-decoration-none text-center">
                                <i class="fa-solid fa-receipt me-1"></i>Ledger
                            </a>

                            <!-- Edit Router View Link -->
                            <a href="{{ route('admin.shops.edit', $shop->id) }}" class="btn btn-sm btn-action-info-outline px-2.5 fw-semibold text-decoration-none text-center">
                                <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                            </a>

                            <!-- Destructive Drop Node Action Form -->
                            <form action="{{ route('admin.shops.delete', $shop->id) }}" method="POST" class="d-inline mb-0" onsubmit="return confirm('Confirm destructive truncate operation on target shop node alignment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-action-danger-outline px-2.5 fw-semibold">
                                    <i class="fa-solid fa-trash-can me-1"></i>Drop Store
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-white-50" style="color: #a8aeb4 !important;">
                        <i class="fa-solid fa-store-slash d-block fs-2 mb-2 text-secondary"></i>
                        No explicit vendor node structures available in the current framework sequence.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection