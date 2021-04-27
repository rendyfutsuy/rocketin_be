@extends('contributorPanel::layouts.app-with-sidebar')

@section('title')
    Rejected List - {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <contributor-rejected-post-page>
        
    </contributor-rejected-post-page>
@endsection

@section("script")
@parent
@endsection
