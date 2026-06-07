<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sunshine Squad</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    .luxury-navbar {
        background-color: #151b2d !important;
        border-bottom: 2px solid #d4af37;
    }

    .gold-text { color: #d4af37 !important; }

    .nav-link:hover { color: #d4af37 !important; }

    .notification-badge {
        font-size: 0.65rem;
        position: absolute;
        top: 1px;
        right: 1px;
    }

    .dropdown-menu-dark {
        background-color: #1a1a1a;
        border: 1px solid #333333;
    }

    .notification-item {
        transition: 0.2s;
        border-bottom: 1px solid #2d2d2d;
    }

    .notification-item:hover {
        background-color: #252525;
    }

    /* CATEGORY SECTION */
    .category-section-title {
        font-size: 13px;
        letter-spacing: 1px;
        color: #bebebe;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .category-bar {
        background: #38362f;
        border-bottom: 3px solid #5a5a5a;
        padding: 14px 0;
    }

    .category-card {
        background: #1a1a1a;
        border: 1px solid #2d2d2d;
        border-radius: 12px;
        padding: 12px 16px;
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s ease;
        white-space: nowrap;
        font-size: 14px;
    }

    .category-card:hover {
        transform: translateY(-2px);
        border-color: #d4af37;
        color: #d4af37;
    }
  </style>
</head>

<body class="luxury-bg text-white bg-dark">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark luxury-navbar shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold gold-text" href="/">
      <i class="fa-solid fa-sun me-2"></i>Sunshine Squad
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">

      <ul class="navbar-nav mx-auto">

        <li class="nav-item">
          <a class="nav-link" href="/">
            <i class="fa-solid fa-house me-1"></i> Home
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/products">
            <i class="fa-solid fa-store me-1"></i> Products
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/deals">
            <i class="fa-solid fa-tags me-1"></i> Deals
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/contact">
            <i class="fa-solid fa-envelope me-1"></i> Contact
          </a>
        </li>

      </ul>

      <form class="d-flex" method="GET" action="/search">
        <input class="form-control bg-secondary text-white border-0 me-2"
               type="search"
               name="q"
               placeholder="Search products...">
        <button class="btn btn-warning" type="submit">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>

      <ul class="navbar-nav ms-3 align-items-center gap-2">

        @auth

        <!-- USER DROPDOWN -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle gold-text fw-semibold d-flex align-items-center gap-2"
             href="#" data-bs-toggle="dropdown">

            <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                 width="28" height="28"
                 class="rounded-circle border border-warning">

            {{ Auth::user()->name }}
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">

            <li class="dropdown-item text-muted small">
              Role: {{ Auth::user()->role }}
            </li>

            <li><hr class="dropdown-divider border-secondary"></li>

            <li>
              <a class="dropdown-item" href="/profile">
                <i class="fa-solid fa-user-pen me-2"></i>Profile
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-gauge-high me-2"></i>Dashboard
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="/cart">
                <i class="fa-solid fa-basket-shopping me-2"></i>My Cart
              </a>
            </li>

            <li><hr class="dropdown-divider border-secondary"></li>

            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item text-danger">
                  <i class="fa-solid fa-power-off me-2"></i>Logout
                </button>
              </form>
            </li>

          </ul>
        </li>

        @else
          <li><a class="nav-link" href="/login">Login</a></li>
          <li><a class="btn btn-warning btn-sm" href="/register">Register</a></li>
        @endauth

      </ul>
    </div>
  </div>
</nav>

<!-- CATEGORY SECTION -->
<div class="category-bar">
  <div class="container">

    <div class="category-section-title">
      Shop by Categories
    </div>

    <div class="d-flex gap-3 overflow-auto">

      <a href="/category/solar-panels" class="category-card">
        <i class="fa-solid fa-solar-panel gold-text"></i>
        Solar Panels
      </a>

      <a href="/category/inverters" class="category-card">
        <i class="fa-solid fa-bolt gold-text"></i>
        Inverters
      </a>

      <a href="/category/iot" class="category-card">
        <i class="fa-solid fa-network-wired gold-text"></i>
        IoT Devices
      </a>

      <a href="/category/batteries" class="category-card">
        <i class="fa-solid fa-car-battery gold-text"></i>
        Batteries
      </a>

      <a href="/category/smart-home" class="category-card">
        <i class="fa-solid fa-house-laptop gold-text"></i>
        Smart Home
      </a>

    </div>
  </div>
</div>

@if(session('status') || session('success'))
<div class="container mt-3">
  <div class="alert alert-success bg-success text-white border-0">
    {{ session('status') ?? session('success') }}
  </div>
</div>
@endif

<main class="container py-4">
  @yield('content')
</main>

<footer class="footer-elite mt-5 pt-5 bg-black border-top border-secondary">
  <div class="container">
    <div class="row g-4">

      <div class="col-md-3">
        <h5 class="footer-title text-warning fw-bold mb-3">☀️ Sunshine Squad</h5>
        <p class="text-white-50 small lh-base">Luxury marketplace for solar, IoT infrastructure, and smart automation lifestyles.</p>
      </div>

      <div class="col-md-3">
        <h5 class="footer-title text-white fw-bold mb-3">Customer Care</h5>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="{{ route('faq') }}" class="footer-link-premium text-white-50 text-decoration-none">FAQs</a></li>
          <li class="mb-2"><a href="{{ route('returns') }}" class="footer-link-premium text-white-50 text-decoration-none">Returns & refunds</a></li>
          <li class="mb-2"><a href="{{ route('shipping') }}" class="footer-link-premium text-white-50 text-decoration-none">Shipping & delivery</a></li>
          <li class="mb-2"><a href="{{ route('warranty') }}" class="footer-link-premium text-white-50 text-decoration-none">Warranty systems</a></li>
        </ul>
      </div>

      <div class="col-md-3">
        <h5 class="footer-title text-white fw-bold mb-3">Legal Information</h5>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="{{ route('privacy') }}" class="footer-link-premium text-white-50 text-decoration-none">Privacy policy</a></li>
          <li class="mb-2"><a href="{{ route('terms') }}" class="footer-link-premium text-white-50 text-decoration-none">Terms of service</a></li>
          <li class="mb-2"><a href="{{ route('cookies') }}" class="footer-link-premium text-white-50 text-decoration-none">Cookie policy</a></li>
          <li class="mb-2"><a href="{{ route('security') }}" class="footer-link-premium text-white-50 text-decoration-none">Platform Security</a></li>
        </ul>
      </div>

      <div class="col-md-3">
        <h5 class="footer-title text-white fw-bold mb-3">Contact Desk</h5>
        <ul class="list-unstyled small text-white-50 mb-0">
          <li class="mb-2">
            <span class="d-block text-secondary extra-small-label fw-bold">Email</span>
            <a href="mailto:support@sunshine-squad.test" class="text-white-50 text-decoration-none footer-link-premium">support@sunshine-squad.test</a>
          </li>
          <li class="mb-3">
            <span class="d-block text-secondary extra-small-label fw-bold">Phone</span>
            <a href="tel:+923000000000" class="text-white-50 text-decoration-none footer-link-premium">+92 300 0000000</a>
          </li>
          <li>
            <a href="{{ route('contact') }}" class="btn btn-outline-warning btn-sm py-2 px-3 w-100 fw-bold premium-contact-btn">
              Contact Form
            </a>
          </li>
        </ul>
      </div>

    </div>

    <hr class="my-4 border-secondary opacity-25">

    <div class="d-flex flex-column flex-md-row justify-content-between pb-4 text-white-50 small gap-3">
      <small>© {{ date('Y') }} Sunshine Squad. All rights reserved.</small>
      <div class="d-flex flex-wrap gap-4">
        <a href="{{ route('sellers') }}" class="footer-link-premium text-white-50 text-decoration-none">Become a seller</a>
        <a href="{{ route('brand_partners') }}" class="footer-link-premium text-white-50 text-decoration-none">Brand partners</a>
        <a href="{{ route('affiliate') }}" class="footer-link-premium text-white-50 text-decoration-none">Affiliate program</a>
      </div>
    </div>
  </div>
</footer>

<style>
  .footer-elite {
    background-color: #0d0d0e !important; /* Premium rich deep canvas black */
  }
  
  /* High-end hover experience */
  .footer-link-premium {
    transition: color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
  }
  
  .footer-link-premium:hover {
    color: #ffffff !important; /* Brightens link to fully crisp white */
    text-decoration: underline !important;
    text-underline-offset: 5px; /* Adds spatial separation from baseline text */
    text-decoration-thickness: 1px;
  }
  
  /* Modern CTA Button transition */
  .premium-contact-btn {
    transition: all 0.25s ease-in-out;
    letter-spacing: 0.3px;
  }
  
  .premium-contact-btn:hover {
    background-color: #ffc107 !important;
    color: #000000 !important;
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.25);
    transform: translateY(-1px);
  }
  
  .extra-small-label {
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>