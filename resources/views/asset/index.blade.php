@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Assets</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('asset.create') }}" class="btn btn-primary mb-3">Add New Asset</a>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Location</th>
                <th>Category</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Description</th>

            </tr>
            </thead>
            <tbody>
            @foreach($assets as $asset)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $asset->location ? $asset->location->rack . '.' . $asset->location->row : 'N/A' }}</td>
                    <td>{{ $asset->category ? $asset->category->name : 'N/A' }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->quantity }}</td>
                    <td>{{ $asset->status }}</td>
                    <td>{{ $asset->description }}</td>
                    <td>
                        <a href="{{ route('asset.edit', $asset->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('asset.destroy', $asset->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
