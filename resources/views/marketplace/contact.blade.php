@extends('layouts.app')

@section('content')
<h2 class="mb-4 gold-text">Contact us</h2>
<div class="row">
    <div class="col-lg-6">
        <form class="luxury-panel p-3 rounded">
            <div class="mb-3">
                <label class="form-label">Your name</label>
                <input type="text" class="form-control" placeholder="John Doe">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="john@example.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea class="form-control" rows="5" placeholder="Tell us how we can help"></textarea>
            </div>
            <button class="btn btn-gold">Send</button>
        </form>
    </div>
    <div class="col-lg-6">
        <div class="p-4 luxury-panel rounded h-100">
            <h5 class="gold-text">Support</h5>
            <p>Email: support@sunshine-squad.test</p>
            <p>Phone: +92 300 0000000</p>
        </div>
    </div>
</div>
@endsection
