@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Assets</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="javascript:void(0);" class="btn btn-primary mb-3" data-toggle="modal" data-target="#requestAssetModal">Request Asset</a>
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
                <th>Actions</th>
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

    <!-- Request Asset Modal -->
    <div class="modal fade" id="requestAssetModal" tabindex="-1" aria-labelledby="requestAssetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestAssetModalLabel">Request Asset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('requests.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="asset_id">Select Asset</label>
                            <select name="asset_id" id="asset_id" class="form-control" required>
                                <option value="">Select an Asset</option>
                                @foreach($assets as $asset)
                                    @if($asset->status === 'available')
                                        <option value="{{ $asset->id }}">{{ $asset->name }} ({{ $asset->location ? $asset->location->rack . '.' . $asset->location->row : 'N/A' }})</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-info">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
