@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center" style="color: red;">All Asset Requests</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Request Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>User</th>
                    <th>Asset</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Requested At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requests as $index => $request)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->asset->name }}</td>
                        <td>{{ $request->quantity }}</td>
                        <td>
                            @if($request->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($request->status === 'approved')
                                <span class="badge badge-success">Approved</span>
                            @elseif($request->status === 'rejected')
                                <span class="badge badge-danger">Rejected</span>
                            @else
                                <span class="badge badge-secondary">Unknown</span>
                            @endif
                        </td>
                        <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group">
                                <!-- Dropdown Toggle Button -->
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>

                                <!-- Dropdown Menu -->
                                <div class="dropdown-menu">
                                    @if($request->status === 'pending')
                                        <!-- Approve Button -->
                                        <form action="{{ route('requests.approve', $request->id) }}" method="POST" class="dropdown-item p-0 m-0">
                                            @csrf
                                            <button type="submit" class="btn w-100 text-left d-flex align-items-center text-success" style="border: none; background: none; padding: 10px;">
                                                <i class="fas fa-check mr-2"></i> Approve
                                            </button>
                                        </form>

                                        <!-- Reject Button -->
                                        <form action="{{ route('requests.reject', $request->id) }}" method="POST" class="dropdown-item p-0 m-0">
                                            @csrf
                                            <button type="submit" class="btn w-100 text-left d-flex align-items-center text-danger" style="border: none; background: none; padding: 10px;">
                                                <i class="fas fa-times mr-2"></i> Reject
                                            </button>
                                        </form>

                                        <!-- Divider -->
                                        <div class="dropdown-divider"></div>

                                        <!-- Edit Button -->
                                        <a href="{{ route('requests.edit', $request->id) }}" class="dropdown-item d-flex align-items-center">
                                            <i class="fas fa-edit mr-2"></i> Edit
                                        </a>

                                        <!-- Divider -->
                                        <div class="dropdown-divider"></div>
                                    @endif

                                    <!-- Delete Button -->
                                    <form action="{{ route('requests.destroy', $request->id) }}" method="POST" class="dropdown-item p-0 m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn w-100 text-left d-flex align-items-center text-secondary" style="border: none; background: none; padding: 10px;">
                                            <i class="fas fa-trash-alt mr-2"></i> Delete
                                        </button>
                                    </form>
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
                {{ $requests->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
