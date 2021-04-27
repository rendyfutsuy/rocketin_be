@extends('adminPanel::layouts.app-with-sidebar')

@section('content')
    <post-edit
        :form="{{ $post }}"
    ></post-edit>
@endsection

@section("script")
@parent
@endsection
