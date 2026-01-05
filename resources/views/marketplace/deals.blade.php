@extends('layouts.app')

@section('content')
<h2 class="text-center mb-4 gold-text">Exclusive Deals & Services</h2>

<div id="dealGrid" class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-4">
  @for($i=1; $i<=16; $i++)
  <div class="col deal-card {{ $i > 8 ? 'd-none' : '' }}">
    <div class="card luxury-card h-100 fade-up">
      <img src="/images/deal{{$i}}.jpg" class="card-img-top" alt="Deal {{$i}}">
      <div class="card-body text-center">
        <h5 class="card-title"><strong>Deal {{$i}}</strong></h5>
        <p class="card-text">Bundle offer with huge savings.</p>

        {{-- Grab Deal button --}}
        <button class="btn btn-warning btn-sm"
                @guest onclick="showLoginPopup()" @else data-bs-toggle="modal" data-bs-target="#dealModal{{$i}}" @endguest>
          Grab Deal
        </button>
      </div>
    </div>
  </div>

  {{-- Deal detail modal (only for logged in users) --}}
  @auth
  <div class="modal fade" id="dealModal{{$i}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-4">
        <h4><strong>Deal {{$i}} Details</strong></h4>
        <img src="/images/deal{{$i}}.jpg" class="img-fluid rounded mb-3" alt="Deal {{$i}}">

        <p><strong>Extra Services:</strong> Example service description</p>
        <p><strong>Service Range:</strong> Example range info</p>
        <p><strong>Product Price:</strong> $100</p>
        <p><strong>Servicing Price:</strong> $20</p>
        <p><strong>Payment Method:</strong> Cash on Delivery / Online</p>
        <p><strong>Company Contact:</strong> 0300‑0000000</p>

        <form method="POST" action="{{ route('cart.add', $i) }}">
          @csrf
          <button type="submit" class="btn btn-warning">Grab Deal</button>
        </form>
      </div>
    </div>
  </div>
  @endauth
  @endfor
</div>

<div class="text-center mt-4">
  <button id="showMoreDeals" class="btn btn-outline-light me-2">Show more</button>
  <button id="showLessDeals" class="btn btn-outline-light">Show less</button>
</div>
@endsection

@section('scripts')
<script>
  function showLoginPopup() {
    alert("⚠️ Please register or log in to grab deals.");
  }

  document.getElementById('showMoreDeals')?.addEventListener('click', () => {
    document.querySelectorAll('#dealGrid .deal-card.d-none').forEach(el => {
      el.classList.remove('d-none');
      el.classList.add('fade-up');
    });
  });

  document.getElementById('showLessDeals')?.addEventListener('click', () => {
    document.querySelectorAll('#dealGrid .deal-card').forEach((el, idx) => {
      if (idx >= 8) el.classList.add('d-none');
    });
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
@endsection
