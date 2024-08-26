@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4" style="color: red;">Edit Transaction</h1>

        <div class="card shadow-lg">
            <div class="card-body">
                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="remark" style="color: #007bff;"><i class="fas fa-align-left"></i> Remark</label>
                        <textarea name="remark" id="remark" class="form-control" rows="3">{{ old('remark', $transaction->remark) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-md-end">
                            <button class="btn btn-primary btn-lg rounded-pill me-2" type="submit"><i class="fas fa-save"></i> Update Transaction</button>
                            <button class="btn btn-secondary btn-lg rounded-pill" type="reset"><i class="fas fa-undo"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
