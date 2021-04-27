@extends('contributorPanel::layouts.app-with-sidebar')

@section('title')
    Dashboard - {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
<contributor-home
    version="{{ config('app.version') }}"
></contributor-home>
@endsection

@section("script")
@parent

@endsection
