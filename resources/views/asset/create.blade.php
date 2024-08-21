@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Asset</h1>

        <form action="{{ route('asset.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="location_id">Location</label>
                <select id="location_id" name="location_id" class="form-control" required>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">
                            {{ $location->rack }}.{{ $location->row }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Asset Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="available">Available</option>
                    <option value="in use">In Use</option>
                    <option value="damaged">Damaged</option>
                    <option value="unavailable">Unavailable</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create Asset</button>
        </form>
    </div>
@endsection
