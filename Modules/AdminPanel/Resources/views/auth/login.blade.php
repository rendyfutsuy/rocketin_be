@extends('adminPanel::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <span class="row justify-content-center my-4">
                        <img src="{{ url('image/logo_kolombaris.svg') }}" width="20%">
                    </span>
                    <form id="login-form">
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <input
                                    id="login"
                                    type="login"
                                    class="form-control @error('login') is-invalid @enderror"
                                    name="login" value="{{ old('login') }}"
                                    required
                                    autocomplete="login"
                                    autofocus
                                    placeholder="{{ __('Email/Username') }}"
                                >

                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="{{ __('Password') }}"
                                >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-0 row justify-content-center">
                            <div class="col-md-6">
                                <button type="button" id="submit-login" class="form-control btn btn-outline-kolombaris font-weight-bold">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
@parent
<script>
    $(function () {
        $(document).on("click", "#submit-login", function(event) {       
            axios.post("{{ route('api.admin.login')}}", 
                {
                    login: $("#login").val(),
                    password: $("#password").val(),
                }
            ).then(response => {
                // alert('Berhasil masuk. Pengguna akan segera di pindahkan.');
                console.log(response.data.access_token);
                sessionStorage.setItem("adminToken", response.data.access_token);
                window.location.href = "{{ route('super.admin.home') }}";
            }).catch(function (error) {
                alert("Gagal Login");
                console.log(error);
            });
        });
    });
</script>
@endsection
