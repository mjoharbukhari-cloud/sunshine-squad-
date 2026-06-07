@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Deals Management</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('admin.deals.create') }}" class="btn btn-primary mb-3">Add Deal</a>
    
    <div class="card">
        <div class="card-header">
            All Deals
        </div>
        <div class="card-body">
            @if($deals->count() > 0)
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Shop</th>
                            <th>Image</th>
                            <th>Approved</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deals as $deal)
                        <tr>
                            <td>{{ $deal->id }}</td>
                            <td>{{ $deal->title }}</td>
                            <td>{{ $deal->description }}</td>
                            <td>{{ $deal->shop->name ?? 'Admin' }}</td>
                            <td>
                                @if($deal->image)
                                    <img src="{{ asset('storage/'.$deal->image) }}" alt="Deal Image" width="60">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($deal->approved)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-warning text-dark">No</span>
                                @endif
                            </td>
                            <td>
                                @if(!$deal->approved)
                                    <form action="{{ route('admin.deals.approve', $deal->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button class="btn btn-sm btn-success" onclick="return confirm('Approve this deal?')">Approve</button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.deals.delete', $deal->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this deal?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">No deals found.</p>
            @endif
        </div>
    </div>
</div>
@endsection