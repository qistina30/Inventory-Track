<!-- resources/views/transactions/return.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Return Asset</h1>

        <form action="{{ route('transactions.processReturn', $transaction->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="remark">Remark (optional)</label>
                <textarea name="remark" id="remark" class="form-control">{{ old('remark') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Return</button>
        </form>
    </div>
@endsection

