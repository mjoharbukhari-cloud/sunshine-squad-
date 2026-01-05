<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sunshine Squad</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="luxury-bg">
  <nav class="navbar navbar-expand-lg navbar-dark luxury-navbar shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold gold-text" href="/">☀️ Sunshine Squad</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="/deals">Deals & Services</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">Categories</a>
            <ul class="dropdown-menu luxury-dropdown">
              <li><a class="dropdown-item" href="/category/solar-panels">Solar panels</a></li>
              <li><a class="dropdown-item" href="/category/inverters">Inverters</a></li>
              <li><a class="dropdown-item" href="/category/iot">IoT devices</a></li>
              <li><a class="dropdown-item" href="/category/batteries">Batteries</a></li>
              <li><a class="dropdown-item" href="/category/smart-home">Smart home</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
        </ul>

        <form class="d-flex" method="GET" action="/search">
          <input class="form-control me-2" type="search" name="q" placeholder="Search products, deals, categories">
          <button class="btn btn-primary" type="submit">Search</button>
        </form>

        <ul class="navbar-nav ms-3">
          <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
        </ul>
      </div>
    </div>
  </nav>

  @if(session('status'))
    <div class="container mt-3">
      <div class="alert alert-success">{{ session('status') }}</div>
    </div>
  @endif

  <main class="container py-4">
    @yield('content')
  </main>

  <footer class="footer-elite mt-5 pt-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-3">
          <h5 class="footer-title">Sunshine Squad</h5>
          <p class="footer-text">Luxury marketplace for solar, IoT, and smart living.</p>
          <div class="socials d-flex gap-3">
            <a href="#" class="social-link">Facebook</a>
            <a href="#" class="social-link">Instagram</a>
            <a href="#" class="social-link">Twitter/X</a>
            <a href="#" class="social-link">LinkedIn</a>
          </div>
        </div>
        <div class="col-md-3">
          <h5 class="footer-title">Customer care</h5>
          <ul class="footer-list">
            <li><a href="/faq">FAQs</a></li>
            <li><a href="/returns">Returns & refunds</a></li>
            <li><a href="/shipping">Shipping & delivery</a></li>
            <li><a href="/warranty">Warranty & repairs</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5 class="footer-title">Legal</h5>
          <ul class="footer-list">
            <li><a href="/privacy">Privacy policy</a></li>
            <li><a href="/terms">Terms of service</a></li>
            <li><a href="/cookies">Cookie policy</a></li>
            <li><a href="/security">Security</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5 class="footer-title">Contact</h5>
          <ul class="footer-list">
            <li>Email: support@sunshine-squad.test</li>
            <li>Phone: +92 300 0000000</li>
            <li><a href="/contact" class="btn btn-primary btn-sm mt-2">Contact form</a></li>
          </ul>
        </div>
      </div>
      <hr class="footer-sep my-4">
      <div class="d-flex justify-content-between pb-4">
        <small class="footer-text">© 2025 Sunshine Squad. All rights reserved.</small>
        <div class="d-flex gap-3">
          <a href="/sellers" class="footer-link">Become a seller</a>
          <a href="/brand-partners" class="footer-link">Brand partners</a>
          <a href="/affiliate" class="footer-link">Affiliate program</a>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
</body>
</html>
