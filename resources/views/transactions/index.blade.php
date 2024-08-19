@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Transaction History</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Asset</th>
                <th>Quantity</th>
                <th>Transaction Type</th>
                <th>Transaction Date</th>
                <th>Remark</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->asset->name }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>{{ ucfirst($transaction->transaction_type) }}</td>
                    <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                    <td>{{ $transaction->remark }}</td>
                    <td>
                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning">Edit</a>
                        @if($transaction->transaction_type === 'checkout')
                            <a href="{{ route('transactions.return', $transaction->id) }}" class="btn btn-info">Return Asset</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
