@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white">{{ __('Account Status') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are registered!') }}
                    <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Login') }}</a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
