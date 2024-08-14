@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Asset Requests</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Asset</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Requested At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->asset->name }}</td>
                    <td>{{ $request->quantity }}</td>
                    <td>{{ ucfirst($request->status) }}</td>
                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($request->status === 'pending')
                            <form action="{{ route('requests.approve', $request->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <form action="{{ route('requests.reject', $request->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        @else
                            <span>{{ ucfirst($request->status) }}</span>
                        @endif
                            <!-- Delete Button -->
                            <form action="{{ route('requests.destroy', $request->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary">Delete</button>
                            </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
