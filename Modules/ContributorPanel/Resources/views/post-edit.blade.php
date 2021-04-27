@extends('contributorPanel::layouts.app-with-sidebar')

@section('title')
    {{ $post->title }} - {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <post-edit
        :form="{{ $post }}"
    ></post-edit>
@endsection

@section("script")
@parent
@endsection
