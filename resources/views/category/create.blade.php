@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4" style="color: red;">Add New Category</h1>

        <div class="card shadow-lg">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('category.store') }}" method="POST">
                    @csrf

                    <!-- First Row: Category Name -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" style="color: #007bff;"><i class="fas fa-tag"></i> Category Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Second Row: Description -->
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="description" style="color: #007bff;"><i class="fas fa-align-left"></i> Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row">
                        <div class="col-md-12 text-md-end">
                            <button class="btn btn-primary btn-lg rounded-pill me-2" type="submit"><i class="fa fa-plus"></i> Add Category</button>
                            <button class="btn btn-secondary btn-lg rounded-pill" type="reset"><i class="fas fa-undo"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
