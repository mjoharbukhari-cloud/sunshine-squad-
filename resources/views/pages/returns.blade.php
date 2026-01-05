@extends('layouts.app')

@section('content')
<h2 class="mb-3 gold-text">Returns & Refunds</h2>
<div class="luxury-card p-4">

  {{-- Introduction --}}
  <h5 class="gold-text">Overview</h5>
  <p class="footer-text">
    At Sunshine Squad Marketplace, we want you to be completely satisfied with your purchase.
    If for any reason you are not happy, our Returns & Refunds policy ensures a smooth process.
  </p>

  {{-- Return Policy --}}
  <h5 class="gold-text mt-4">Return Policy</h5>
  <ul>
    <li class="footer-text">Products can be returned within <strong>7 days</strong> of delivery.</li>
    <li class="footer-text">Items must be unused, in original packaging, and accompanied by proof of purchase.</li>
    <li class="footer-text">Returns are not accepted for clearance, customized, or hygiene-sensitive items.</li>
  </ul>

  {{-- Refunds --}}
  <h5 class="gold-text mt-4">Refunds</h5>
  <p class="footer-text">
    Once your return is received and inspected, we will notify you of the approval or rejection of your refund.
    Approved refunds will be processed within <strong>5–7 business days</strong> using your original payment method
    (Easypaisa, JazzCash, or Cash on Delivery reversal).
  </p>

  {{-- Exchanges --}}
  <h5 class="gold-text mt-4">Exchanges</h5>
  <p class="footer-text">
    If you need to exchange an item for a different size, color, or model, please contact our support team.
    Exchanges are subject to product availability.
  </p>

  {{-- Process --}}
  <h5 class="gold-text mt-4">How to Initiate a Return</h5>
  <ol>
    <li class="footer-text">Log in to your Customer Dashboard.</li>
    <li class="footer-text">Go to “My Orders” and select the item you wish to return.</li>
    <li class="footer-text">Click “Request Return” and fill out the form.</li>
    <li class="footer-text">Our team will arrange pickup or guide you to the nearest drop-off point.</li>
  </ol>

  {{-- Contact --}}
  <h5 class="gold-text mt-4">Need Help?</h5>
  <p class="footer-text">
    For questions about returns or refunds, contact our support team at
    <strong>support@sunshine-squad.test</strong> or call <strong>+92 300 0000000</strong>.
  </p>

</div>
@endsection
