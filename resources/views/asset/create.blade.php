@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4" style="color: red;">Create New Asset</h1>

        <div class="card shadow-lg">
            <div class="card-body">
                <form action="{{ route('asset.store') }}" method="POST">
                    @csrf

                    <!-- First Row: Location and Category -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="location_id" style="color: #007bff;"><i class="fas fa-map-marker-alt"></i> Location</label>
                            <select  id="location_id" class="form-select form-control" aria-label="Default select example" >
                                <option selected>Select an option</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">
                                        {{ $location->rack }}.{{ $location->row }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="category_id" style="color: #007bff;"><i class="fas fa-list-alt"></i> Category</label>
                            <select id="category_id" class="form-select form-control" aria-label="Default select example">
                                <option selected>Select an option</option>
                                @foreach($categories->sortBy('name') as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>



                    <!-- Second Row: Asset Name and Quantity -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" style="color: #007bff;"><i class="fas fa-box"></i> Asset Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="quantity" style="color: #007bff;"><i class="fas fa-sort-numeric-up-alt"></i> Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" required>
                        </div>
                    </div>

                    <!-- Third Row: Status and Description -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" style="color: #007bff;"><i class="fas fa-info-circle"></i> Status</label>
                            <select  id="status" class="form-select form-control" aria-label="Default select example" >
                                <option value="available">Available</option>
                                <option value="damaged">Damaged</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="description" style="color: #007bff;"><i class="fas fa-align-left"></i> Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row">
                        <div class="col-md-12 text-md-end">
                            <button class="btn btn-primary btn-lg rounded-pill me-2" type="submit"><i class="fa fa-plus"></i> Add Asset</button>
                            <button class="btn btn-secondary btn-lg rounded-pill" type="reset"><i class="fas fa-undo"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
