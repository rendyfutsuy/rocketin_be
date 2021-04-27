@extends('adminPanel::layouts.app-with-sidebar')

@section('title')
    Rejected List - {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <rejected-post-page>
        
    </rejected-post-page>
@endsection

@section("script")
@parent
@endsection
