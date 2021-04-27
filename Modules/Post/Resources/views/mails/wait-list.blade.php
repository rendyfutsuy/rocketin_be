@extends('auth::mail.layout-blank')

@section('content')
    <style>
        .submit {
            color: #000;
            text-align:center;
            padding: 10px;
            width: '95%';
            margin: auto;
            color: #ffffff;
            background: #2453FF;
        }

    </style>

    {!! __('post::wait-list.content', [
        'title' => $title,
    ], $locale) !!}
    @if (empty($wpLink))
        <br>
        <a href="{{ $wpLink }}"> Wordpress Url</a>
        <br>
    @endif
    <a href="{{ $postLink }}"> Post Detail Url</a>
@endsection
