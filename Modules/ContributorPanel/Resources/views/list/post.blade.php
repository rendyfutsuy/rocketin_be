@extends('contributorPanel::layouts.app-with-sidebar')

@section('title')
    Post - {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <contributor-post-page></contributor-post-page>
@endsection

@section("script")
@parent
@endsection
