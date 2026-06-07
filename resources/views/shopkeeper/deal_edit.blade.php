@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 650px;">
    <div class="card bg-dark text-white border-0 shadow p-4" style="border-radius:12px; background-color: #121416 !important; border: 1px solid #23272a !important;">
        <h4 class="fw-bold gold-text mb-3"><i class="fa-solid fa-tags me-2 text-warning"></i>Modify Promo Package Setup</h4>

        <form action="{{ route('shopkeeper.deals.update', $deal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Deal Title</label>
                <input type="text" name="title" id="title" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" value="{{ $deal->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Deal Specifications Summary</label>
                <textarea name="description" id="description" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" rows="4" required>{{ $deal->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Bundle Price Point (PKR)</label>
                <input type="number" name="price" id="price" class="form-control bg-secondary bg-opacity-10 border-secondary text-white p-2.5" value="{{ $deal->price }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label small text-white-50 text-uppercase fw-bold">Change Promotional Image Graphic File</label>
                <input type="file" name="image" id="image" class="form-control bg-secondary bg-opacity-10 border-secondary text-white mb-2">
                @if($deal->image)
                    <div class="p-2 border border-secondary rounded d-inline-block bg-black">
                        <img src="{{ asset('storage/'.$deal->image) }}" class="img-fluid" style="max-width:140px; border-radius:6px;">
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between align-items-center pt-2">
                <a href="{{ route('shopkeeper.deals') }}" class="text-white-50 small text-decoration-none">Cancel modifications</a>
                <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">Update Bundle Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection