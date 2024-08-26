@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4" style="color: red;">Edit Request</h1>

        <div class="card shadow-lg">
            <div class="card-body">
                <form action="{{ route('requests.update', $request->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="asset_id" style="color: #007bff;"><i class="fas fa-box-open"></i> Select Asset</label>
                        <select name="asset_id" id="asset_id" class="form-control form-select" required>
                            @foreach($assets->sortBy('name') as $asset)
                                <option value="{{ $asset->id }}" {{ $request->asset_id == $asset->id ? 'selected' : '' }}>
                                    {{ $asset->name }} ({{ $asset->location ? $asset->location->rack . '.' . $asset->location->row : 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="quantity" style="color: #007bff;"><i class="fas fa-sort-numeric-up-alt"></i> Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ $request->quantity }}" min="1" class="form-control" required>
                    </div>

                    <!-- Buttons -->
                    <div class="row">
                        <div class="col-md-12 text-md-end">
                            <button class="btn btn-primary btn-lg rounded-pill me-2" type="submit"><i class="fas fa-save"></i> Save Changes</button>
                            <a href="{{ route('asset.index') }}" class="btn btn-secondary btn-lg rounded-pill"><i class="fas fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

