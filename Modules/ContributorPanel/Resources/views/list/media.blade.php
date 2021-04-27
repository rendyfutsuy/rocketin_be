@extends('contributorPanel::layouts.app-with-sidebar')

@section('title')
    Media - {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <contributor-media-page></contributor-media-page>
@endsection

@section("script")
@parent
@endsection
