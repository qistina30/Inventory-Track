@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center" style="color: red;">All Assets</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Form -->
        <div class="d-flex justify-content-between mb-3">
            <!-- Live Search Input -->
            <div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Search by Asset Name">
                <div class="input-group-append">
                    <button class="btn btn-primary search-btn">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>

        </div>

        <!-- Asset Table -->
        <div class="table-responsive" id="asset-table">
            @include('asset.partials.asset-table', ['assets' => $assets])
        </div>

        <!-- Pagination -->
        <div class="row mb-3">
            <div class="col-md-12 d-flex justify-content-center">
                {{ $assets->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- JavaScript for Live Search -->
    <script>
        document.getElementById('search').addEventListener('input', function() {
            let query = this.value;
            let url = "{{ route('asset.search') }}";

            fetch(`${url}?search=${query}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('asset-table').innerHTML = data;
                });
        });
    </script>

    <style>
        /* Enhanced Search Button and Input Styles */
        .input-group .form-control {
            height: calc(2.25rem + 2px); /* Adjust input height to match button */
        }

        .search-btn {
            background-color: blue; /* Primary color */
            border: 2px solid #ff4500; /* Darker border color */
            color: white; /* Text color */
            transition: background-color 0.3s ease, border-color 0.3s ease; /* Smooth transition */
            height: calc(2.25rem + 2px); /* Match the button height with the input */
        }

        .search-btn:hover {
            background-color: red; /* Darker background on hover */
            border-color: red; /* Lighter border on hover */
        }

        .search-btn:disabled {
            background-color: #ccc; /* Disabled state color */
            border-color: #bbb; /* Disabled border color */
            cursor: not-allowed; /* Disabled cursor */
        }

        .input-group .form-control:focus {
            border-color: red; /* Focus border color */
            box-shadow: 0 0 5px rgba(255, 69, 0, 0.5); /* Focus box shadow */
        }
    </style>
@endsection
