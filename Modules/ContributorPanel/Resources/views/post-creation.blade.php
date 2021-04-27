@extends('contributorPanel::layouts.app-with-sidebar')

@section('title')
    Buat Post - {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <post-creation
        success-redirect="{{ route('contributor.list.post') }}"
    ></post-creation>
@endsection

@section("script")
@parent
@endsection
