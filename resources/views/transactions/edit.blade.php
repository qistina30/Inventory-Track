@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Transaction</h1>

        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')

           {{-- <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $transaction->quantity) }}" required>
            </div>--}}

            <div class="form-group">
                <label for="remark">Remark</label>
                <textarea name="remark" id="remark" class="form-control">{{ old('remark', $transaction->remark) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Transaction</button>
        </form>
    </div>
@endsection

