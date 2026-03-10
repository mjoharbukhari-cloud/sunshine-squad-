@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Shop</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.shops.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Shop Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Owner</label>
            <select name="user_id" class="form-control" required>
                <option value="">Select Owner</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Create Shop</button>
    </form>
</div>
@endsection
