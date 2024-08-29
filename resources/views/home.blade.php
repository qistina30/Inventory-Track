@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Notifications Section (Top of the Page) - Admin Only -->
        @if(auth()->user()->isAdmin())
            <div class="row mb-4">
                <div class="col-md-12">
                    @if($pendingRequests > 0)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            You have {{ $pendingRequests }} pending asset requests that need approval.
                            <a href="{{ route('requests.index') }}"> View</a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

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
        @endif

        <!-- Dashboard Overview Section -->
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-boxes fa-3x"></i>
                        <h4 class="card-title mt-2">Total Assets</h4>
                        <h2>{{ $totalAssets }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-3x"></i>
                        <h4 class="card-title mt-2">Available</h4>
                        <h2>{{ $availableAssets }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-exclamation-circle fa-3x"></i>
                        <h4 class="card-title mt-2">Unavailable</h4>
                        <h2>{{ $unavailableAssets }}</h2>
                    </div>
                </div>
            </div>
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

        @if(auth()->user()->isAdmin())
            <!-- Bar Chart for Category Distribution (Admin Only) -->
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
        @endif

        <!-- Recent Transactions Section -->
        @if($recentTransactions->isNotEmpty())
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-history"></i> Recent Transactions
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover align-middle text-center">
                                <thead class="table-dark">
                                <tr>
                                    <th>No.</th>
                                    @if(auth()->user()->isAdmin())
                                        <th>User</th>
                                    @endif
                                    <th>Asset</th>
                                    <th>Quantity</th>
                                    <th>Transaction Type</th>
                                    <th>Transaction Date</th>
                                    <th>Remark</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recentTransactions as $index => $transaction)
                                    <tr>
                                        <!-- Calculate the continuous row number -->
                                        <td>{{ ($recentTransactions->currentPage() - 1) * $recentTransactions->perPage() + $loop->iteration }}</td>
                                        @if(auth()->user()->isAdmin())
                                            <td>{{ $transaction->user->name }}</td>
                                        @endif
                                        <td>{{ $transaction->asset->name }}</td>
                                        <td>{{ $transaction->quantity }}</td>
                                        <td>
                                            @if($transaction->transaction_type === 'checkout')
                                                <span class="badge badge-primary">Checkout</span>
                                            @elseif($transaction->transaction_type === 'return')
                                                <span class="badge badge-success">Return</span>
                                            @else
                                                <span class="badge badge-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                        <td>{{ $transaction->remark }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-edit mr-2"></i> Edit
                                                    </a>
                                                    @if($transaction->transaction_type === 'checkout')
                                                        <div class="dropdown-divider"></div>
                                                        <a href="{{ route('transactions.return', $transaction->id) }}" class="dropdown-item d-flex align-items-center">
                                                            <i class="fas fa-undo mr-2"></i> Return Asset
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

        <!-- Pagination -->
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-center">
                                    {{ $recentTransactions->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Include Chart.js for Admin Chart -->
    @if(auth()->user()->isAdmin())
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    @endif
@endsection
