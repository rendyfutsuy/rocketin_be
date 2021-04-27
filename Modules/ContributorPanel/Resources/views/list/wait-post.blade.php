@extends('contributorPanel::layouts.app-with-sidebar')

@section('title')
    Wait List - {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <contributor-wait-post-page>
        
    </contributor-wait-post-page>
@endsection

@section("script")
@parent
@endsection
