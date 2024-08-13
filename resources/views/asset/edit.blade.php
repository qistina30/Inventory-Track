<!-- resources/views/assets/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Asset</h1>

        <form action="{{ route('asset.update', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="location_id">Location</label>
                <select id="location_id" name="location_id" class="form-control" required>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ $location->id == $asset->location_id ? 'selected' : '' }}>
                            {{ $location->rack }}.{{ $location->row }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $asset->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Asset Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $asset->name }}" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="{{ $asset->quantity }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="available" {{ $asset->status == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="in use" {{ $asset->status == 'in use' ? 'selected' : '' }}>In Use</option>
                    <option value="damaged" {{ $asset->status == 'damaged' ? 'selected' : '' }}>Damaged</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ $asset->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Asset</button>
        </form>
    </div>
@endsection
