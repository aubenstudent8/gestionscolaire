@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger shadow-sm">
                <div class="card-header bg-danger text-white d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-shield-lock-fill me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 0c-.69 0-1.36.05-2 .15C4.9.28 3.5.7 2.5 1.4c-.99.7-1.5 1.6-1.5 2.6 0 4.3 1.8 7.6 5.2 9.8.93.63 2.02.98 3.3.98s2.37-.35 3.3-.98C13.3 11.6 15.1 8.3 15.1 4.0c0-1-.51-1.9-1.5-2.6C12.5.7 11.1.28 10 .15 9.36.05 8.69 0 8 0zM8 7a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                    <strong>{{ __('errors.403_title') }}</strong>
                </div>
                <div class="card-body text-center">
                    <h4 class="card-title">{{ __('errors.403_code') }} — {{ __('errors.403_heading') }}</h4>
                    <p class="card-text">{!! __('errors.403_message') !!}</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">{{ __('errors.back_home') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
