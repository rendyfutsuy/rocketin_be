@extends('layouts.app')

@section('content')
<div class="container" style="height: 85vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth::reset_email.title', [], $lang) }}</div>

                <div class="card-body">
                    <span class="row justify-content-center my-4">
                        <img src="{{ url('image/logo_kolombaris.svg') }}" width="20%">
                    </span>

                    <div
                        style="padding: 5px 10px 35px; background: #B6C2D8; border-radius: 5px;"
                        class="row justify-content-center pt-4 text-success font-weight-bold"
                    >
                        <p>
                            {{ __('auth::reset_email.success', [], $lang) }} <i class="mx-1 fas fa-check-circle"></i>
                        </p>
                    </div>

                </div>
                <footer>
                    <div class="content">
                        <span
                            style="margin: 0.5rem"
                        >
                            &copy; {{ date('Y') }} PT Konsep Dot Net
                        </span>
                
                        <span
                            style="color: #c5c9cc; float: right; margin: 0.5rem"
                        >
                            {{ config('app.version') }}
                        </span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</div>
@endsection
