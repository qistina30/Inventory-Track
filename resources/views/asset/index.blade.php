@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center" style="color: red;">All Assets</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Buttons -->
        <div class="d-flex justify-content-between mb-3">
            {{--<a href="{{ route('requests.create') }}" class="btn btn-primary">
                <i class="fas fa-hand-holding"></i> Request Asset
            </a>--}}
            <a href="{{ route('asset.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Asset
            </a>
        </div>

        <!-- Asset Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-dark">
                <tr>
                    <th>No.</th>
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
                @php
                    $page = $assets->currentPage(); // Current page number
                    $perPage = $assets->perPage(); // Items per page
                    $start = ($page - 1) * $perPage + 1; // Calculate starting number
                @endphp

                @foreach($assets as $index => $asset)
                    <tr>
                        <td>{{ $start + $index }}</td>
                        <td>{{ $asset->location ? $asset->location->rack . '.' . $asset->location->row : 'N/A' }}</td>
                        <td>{{ $asset->category ? $asset->category->name : 'N/A' }}</td>
                        <td>{{ $asset->name }}</td>
                        <td>{{ $asset->quantity }}</td>
                        <td>
                            @if($asset->status === 'available')
                                <span class="badge badge-available">Available</span>
                            @elseif($asset->status === 'in use')
                                <span class="badge badge-in-use">In Use</span>
                            @elseif($asset->status === 'damaged')
                                <span class="badge badge-damage">Damage</span>
                            @else
                                <span class="badge badge-secondary">Unknown</span>
                            @endif
                        </td>
                        <td>{{ $asset->description }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('asset.edit', $asset->id) }}" class="dropdown-item">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    {{--<form action="{{ route('asset.destroy', $asset->id) }}" method="POST" class="dropdown-item">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100 text-left">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>--}}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="row mb-3">
            <div class="col-md-12 d-flex justify-content-center">
                {{ $assets->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
