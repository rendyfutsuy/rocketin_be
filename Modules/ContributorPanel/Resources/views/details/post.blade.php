@extends('contributorPanel::layouts.app-with-sidebar')

@section('content')
    <post-detail-page
        :post-id="{{ $postId }}"
    ></post-detail-page>
@endsection

@section("script")
@parent
@endsection
