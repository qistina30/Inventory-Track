@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center" style="color: red;">Transaction History</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Transaction Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    @if(auth()->user()->isAdmin())
                        <th>Staff Name</th>
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
                @foreach($transactions as $index => $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
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
        </div>

        <!-- Pagination -->
        <div class="row mb-3">
            <div class="col-md-12 d-flex justify-content-center">
                {{ $transactions->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
