@extends('layouts.app')

@section('content')
<h2 class="mb-3 gold-text">Frequently Asked Questions</h2>

<div class="luxury-card p-4">

  {{-- Ordering Section --}}
  <h4 class="gold-text">Ordering</h4>
  <p class="footer-text"><strong>Q:</strong> How do I place an order?<br>
     <strong>A:</strong> Browse products, add them to your cart, and proceed to checkout. You’ll receive an order confirmation email once your purchase is complete.</p>

  <p class="footer-text"><strong>Q:</strong> Can I modify my order after placing it?<br>
     <strong>A:</strong> Orders can be modified within 2 hours of placement by contacting our support team.</p>

  {{-- Shipping Section --}}
  <h4 class="gold-text mt-4">Shipping & Delivery</h4>
  <p class="footer-text"><strong>Q:</strong> How long does delivery take?<br>
     <strong>A:</strong> Standard delivery takes 3–5 business days. Express delivery options are available at checkout.</p>

  <p class="footer-text"><strong>Q:</strong> Do you offer international shipping?<br>
     <strong>A:</strong> Currently, we deliver across Pakistan only. International shipping will be introduced soon.</p>

  {{-- Payments Section --}}
  <h4 class="gold-text mt-4">Payments</h4>
  <p class="footer-text"><strong>Q:</strong> What payment methods are supported?<br>
     <strong>A:</strong> We accept Easypaisa, JazzCash, and Cash on Delivery. Secure online payment gateways will be added in future updates.</p>

  <p class="footer-text"><strong>Q:</strong> Is my payment information secure?<br>
     <strong>A:</strong> Yes, we use encrypted connections and industry-standard security practices to protect your data.</p>

  {{-- Returns Section --}}
  <h4 class="gold-text mt-4">Returns & Refunds</h4>
  <p class="footer-text"><strong>Q:</strong> Can I return a product?<br>
     <strong>A:</strong> Yes, within 7 days of delivery if the product is unused and in original packaging.</p>

  <p class="footer-text"><strong>Q:</strong> How long does it take to process a refund?<br>
     <strong>A:</strong> Refunds are processed within 5–7 business days after the returned item is inspected.</p>

  {{-- Account Section --}}
  <h4 class="gold-text mt-4">Account & Security</h4>
  <p class="footer-text"><strong>Q:</strong> Do I need an account to shop?<br>
     <strong>A:</strong> You can browse products without an account, but you’ll need to register to place orders and track shipments.</p>

  <p class="footer-text"><strong>Q:</strong> How do I reset my password?<br>
     <strong>A:</strong> Click “Forgot Password” on the login page and follow the instructions sent to your email.</p>

</div>
@endsection
