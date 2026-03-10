@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Shops</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Create New Shop --}}
    <h3>Create New Shop</h3>
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

    <hr>

    {{-- List of Shops --}}
    <h3>All Shops</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Owner</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shops as $shop)
            <tr>
                <td>{{ $shop->id }}</td>
                <td>{{ $shop->name }}</td>
                <td>{{ $shop->location }}</td>
                <td>{{ $shop->owner ? $shop->owner->name : 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.shops.edit', $shop->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('admin.shops.delete', $shop->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this shop?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
