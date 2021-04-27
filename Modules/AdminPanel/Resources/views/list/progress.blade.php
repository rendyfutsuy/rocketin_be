@extends('adminPanel::layouts.app-with-sidebar')

@section('content')

<progress-page
    list-ajax-url="{{ route('api.admin.verse.log.list') }}"
>
</progress-page>
@endsection

@section("script")
@parent
@endsection
