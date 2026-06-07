@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white p-5 border border-secondary shadow-lg rounded">
                <h2 class="text-center mb-4 gold-text fw-bold">
                    <i class="fa-solid fa-headset me-2"></i>Contact Sunshine Squad Support
                </h2>
                <p class="text-center text-white-50 mb-4">Have questions about an item or an order? Send us a message and our support panel will get right back to you.</p>

                <form action="#" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Your Full Name</label>
                            <input type="text" class="form-control bg-secondary text-white border-0" required placeholder="John Doe">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Email Address</label>
                            <input type="email" class="form-control bg-secondary text-white border-0" required placeholder="johndoe@example.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white-50">Message Subject</label>
                        <input type="text" class="form-control bg-secondary text-white border-0" required placeholder="Question about order tracking...">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white-50">Detailed Message</label>
                        <textarea class="form-control bg-secondary text-white border-0" rows="5" placeholder="Write your message details here..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-bold text-dark p-2.5">
                        <i class="fa-solid fa-paper-plane me-2"></i>Dispatch Ticket to Support
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection