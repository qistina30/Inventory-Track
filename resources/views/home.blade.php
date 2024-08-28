@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Notifications Section (Top of the Page) -->
        <div class="row mb-4">
            <div class="col-md-12">
                <!-- Pending Requests Notification -->
                @if($pendingRequests > 0)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        You have {{ $pendingRequests }} pending asset requests that need approval.
                        <a href="{{ route('requests.index') }}"> View</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Low Stock Warning -->
                @if($lowStockAssets->isNotEmpty())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        The following assets are low in stock:
                        <ul>
                            @foreach($lowStockAssets as $asset)
                                <li>{{ $asset->name }} ({{ $asset->quantity }} left)</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Dashboard Overview Section -->
        <div class="row text-center">
            <!-- Total Assets Card -->
            <div class="col-md-3 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-boxes fa-3x"></i>
                        <h4 class="card-title mt-2">Total Assets</h4>
                        <h2>{{ $totalAssets }}</h2>
                    </div>
                </div>
            </div>
            <!-- Available Assets Card -->
            <div class="col-md-3 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-3x"></i>
                        <h4 class="card-title mt-2">Available</h4>
                        <h2>{{ $availableAssets }}</h2>
                    </div>
                </div>
            </div>
            <!-- Unavailable Assets Card -->
            <div class="col-md-3 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-exclamation-circle fa-3x"></i>
                        <h4 class="card-title mt-2">Unavailable</h4>
                        <h2>{{ $unavailableAssets }}</h2>
                    </div>
                </div>
            </div>
            <!-- Damaged Assets Card -->
            <div class="col-md-3 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-times-circle fa-3x"></i>
                        <h4 class="card-title mt-2">Damaged</h4>
                        <h2>{{ $damagedAssets }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart for Category Distribution -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-chart-bar"></i> Asset Distribution by Category
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- JavaScript for Bar Chart -->
    <script>
        var ctx = document.getElementById('categoryChart').getContext('2d');
        var categoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($categoryNames) !!},
                datasets: [{
                    label: 'Number of Assets',
                    data: {!! json_encode($assetCounts) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
