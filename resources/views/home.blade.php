@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        <br><br>

                        <!-- Dummy Button to Create New Category Page -->
                        <a href="{{ route('category.index') }}" class="btn btn-primary">
                            {{ __('Category') }}
                        </a>
                            <a href="{{ route('asset.index') }}" class="btn btn-primary">
                                {{ __('Asset') }}
                            </a>
                            <a href="{{ route('requests.index') }}" class="btn btn-primary">
                                {{ __('Request history') }}
                            </a>
                            <a href="{{ route('transactions.index') }}" class="btn btn-primary">
                                {{ __('Transaction History') }}
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
