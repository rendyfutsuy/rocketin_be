@extends('contributorPanel::layouts.app')

@section('content')
<div class="container mt-4">
    <forget-password
        version="{{ config('app.version') }}"
    ></forget-password>
</div>
@endsection

@section("script")
@parent

@endsection
