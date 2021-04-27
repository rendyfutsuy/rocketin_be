<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main class="row p-0 m-0">
            @component('adminPanel::layouts.sidebar')
            
            @endcomponent

            <div id="content" class="col-md py-4">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ mix('/js/app.js') }}"></script>
    <script>
        $( document ).ready(function() {
            if (sessionStorage.getItem("adminToken") == null) {
                window.location.href = "{{ route('super.admin.login.panel') }}";
            }
        });
    </script>
    @yield("script")
</body>
</html>
