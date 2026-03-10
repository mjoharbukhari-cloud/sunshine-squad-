@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 gold-text">Edit Deal</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('shopkeeper.deals.update', $deal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Deal Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $deal->title }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ $deal->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $deal->price }}" required>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $deal->quantity }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image (optional)</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($deal->image)
                <img src="{{ asset('storage/'.$deal->image) }}" class="img-fluid mt-2" style="max-width:200px;">
            @endif
        </div>

        <button type="submit" class="btn btn-warning">Update Deal</button>
    </form>
</div>
@endsection
