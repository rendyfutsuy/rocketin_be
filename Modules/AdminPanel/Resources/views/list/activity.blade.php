@extends('adminPanel::layouts.app-with-sidebar')

@section('content')
    <activity-page
        code-ajax-url="{{ route('api.admin.list.activity.codes') }}"
        list-ajax-url="{{ route('api.admin.user.activity.list')}}"
    ></activity-page>
@endsection

@section("script")
@parent
@endsection
