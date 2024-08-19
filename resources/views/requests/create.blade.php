<!-- resources/views/requests/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Request Asset</h1>
        <form action="{{ route('requests.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="asset_id">Select Asset</label>
                <select name="asset_id" id="asset_id" class="form-control" required>
                    <option value="">Select an Asset</option>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}">{{ $asset->name }} ({{ $asset->location ? $asset->location->rack . '.' . $asset->location->row : 'N/A' }})</option>
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
@endsection

