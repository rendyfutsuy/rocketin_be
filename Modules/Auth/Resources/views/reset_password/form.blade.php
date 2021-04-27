@extends('layouts.app')

@section('content')
<div class="container" style="height: 85vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth::reset_password.title', [], $lang) }}</div>

                <div class="card-body">
                    <span class="row justify-content-center my-4">
                        <img src="{{ url('image/logo_kolombaris.svg') }}" width="20%">
                    </span>

                    <form method="POST" action="{{ route('api.auth.reset.password') }}">
                        @csrf

                        <input type="hidden" name="email" value="{{ $encodedEmail }}">

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <input id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required 
                                    autocomplete="new-password"
                                    placeholder="{{ __('auth::reset_password.password_placeholder', [], $lang) }}"
                                >

                                @error('password')
                                    <span class="invalid-feedback"
                                        role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <input
                                    id="password-confirm"
                                    type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    required autocomplete="new-password"
                                    placeholder="{{ __('auth::reset_password.password_confirmation_placeholder', [], $lang) }}"
                                >
                            </div>
                        </div>

                        <div class="form-group mb-0 row justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" class="form-control btn border-kolombaris text-kolombaris font-weight-bold">
                                    {{ __('auth::reset_password.button', [], $lang) }}
                                </button>
                            </div>
                        </div>
                    </form>
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
