@extends('layouts.app')

@section('content')

    <div class="container">

        <h1 class="text-center mb-4" style="color: red;">Request Asset</h1>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card shadow-lg">
            <div class="card-body">
                <form action="{{ route('requests.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="asset_id" style="color: #007bff;"><i class="fas fa-box-open"></i> Select Asset</label>
                        <select name="asset_id" id="asset_id" class="form-control form-select" required>
                            <option selected>Select an Asset</option>
                            @foreach($assets->sortBy('name') as $asset) <!-- Sorting the assets alphabetically by name -->
                            <option value="{{ $asset->id }}">
                                {{ $asset->name }} ({{ $asset->location ? $asset->location->rack . '.' . $asset->location->row : 'N/A' }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="quantity" style="color: #007bff;"><i class="fas fa-sort-numeric-up-alt"></i> Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" required>
                    </div>

                    <!-- Buttons -->
                    <div class="row">
                        <div class="col-md-12 text-md-end">
                            <button class="btn btn-primary btn-lg rounded-pill me-2" type="submit"><i class="fas fa-paper-plane"></i> Submit Request</button>
                            <button class="btn btn-secondary btn-lg rounded-pill" type="reset"><i class="fas fa-undo"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
