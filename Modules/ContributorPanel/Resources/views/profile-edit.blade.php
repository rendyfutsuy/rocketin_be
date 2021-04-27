@extends('contributorPanel::layouts.app-with-sidebar')

@section('title')
    Profile - {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <profile-edit></profile-edit>
@endsection

@section("script")
@parent
@endsection
