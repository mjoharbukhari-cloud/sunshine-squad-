<div class="list-group shadow-sm">
    
    {{-- ROLE-BASED DASHBOARD LINK --}}
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action fw-bold list-group-item-dark">
            <i class="fa-solid fa-gauge-high me-2 text-danger"></i>Admin Command Hub
        </a>
        <a href="{{ route('admin.shops') }}" class="list-group-item list-group-item-action">
            <i class="fa-solid fa-store me-2"></i>Manage Vendor Stores
        </a>
        <a href="{{ route('admin.products') }}" class="list-group-item list-group-item-action">
            <i class="fa-solid fa-boxes-stacked me-2"></i>Global Inventory
        </a>
    @elseif(Auth::user()->role === 'shopkeeper')
        <a href="{{ route('shopkeeper.dashboard') }}" class="list-group-item list-group-item-action fw-bold active text-white" style="background-color: #121416; border-color: #23272a;">
            <i class="fa-solid fa-chart-line me-2 text-warning"></i>Vendor Dashboard
        </a>
        <a href="{{ route('shopkeeper.products') }}" class="list-group-item list-group-item-action">
            <i class="fa-solid fa-plus me-2 text-success"></i>Manage Products
        </a>
        <a href="{{ route('shopkeeper.deals') }}" class="list-group-item list-group-item-action">
            <i class="fa-solid fa-bolt me-2 text-warning"></i>Manage Bundle Deals
        </a>
    @else
        <a href="{{ route('customer.dashboard') }}" class="list-group-item list-group-item-action fw-bold list-group-item-primary">
            <i class="fa-solid fa-user-shield me-2"></i>Customer Dashboard
        </a>
    @endif

    <hr class="my-1 border-secondary opacity-25">

    {{-- GENERAL MARKETPLACE LINKS ACCESSIBLE BY ALL --}}
    <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action">
        <i class="fa-solid fa-address-card me-2 text-secondary"></i>My Profile
    </a>
    <a href="{{ route('cart.index') }}" class="list-group-item list-group-item-action">
        <i class="fa-solid fa-cart-shopping me-2 text-primary"></i>My Cart 
        <span class="badge bg-primary rounded-pill float-end">{{ $cartCount ?? 0 }}</span>
    </a>
    <a href="{{ route('marketplace.products') }}" class="list-group-item list-group-item-action">
        <i class="fa-solid fa-solar-panel me-2 text-success"></i>Browse Products
    </a>
    <a href="{{ route('marketplace.deals') }}" class="list-group-item list-group-item-action">
        <i class="fa-solid fa-tags me-2 text-info"></i>Hot Deals
    </a>
</div>