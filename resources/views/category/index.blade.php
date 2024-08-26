@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center" style="color: red;">All Categories</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

       {{-- <!-- Buttons -->
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('category.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Category
            </a>
        </div>--}}

        <!-- Category Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $page = $categories->currentPage(); // Current page number
                    $perPage = $categories->perPage(); // Items per page
                    $start = ($page - 1) * $perPage + 1; // Calculate starting number
                @endphp

                @foreach($categories as $index => $category)
                    <tr>
                        <td>{{ $start + $index }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <div class="btn-group">
                                <!-- Dropdown Toggle Button -->
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>

                                <!-- Dropdown Menu -->
                                <div class="dropdown-menu">
                                    <!-- Edit Button -->
                                    <a href="{{ route('category.edit', $category->id) }}" class="dropdown-item d-flex align-items-center">
                                        <i class="fas fa-edit mr-2" style="margin-right: 8px;"></i> Edit
                                    </a>

                                    <!-- Divider -->
                                    <div class="dropdown-divider"></div>

                                    <!-- Delete Button -->
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="dropdown-item p-0 m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn w-100 text-left d-flex align-items-center text-danger" style="border: none; background: none; padding: 10px;">
                                            <i class="fas fa-trash-alt" style="margin-right: 8px;"></i> Delete
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
                {{ $categories->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
