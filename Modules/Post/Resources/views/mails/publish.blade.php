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

    <h4> {!! __('auth::email.layout.title_2', [
        'username' => $userName
    ], $locale) !!} </h4>
    {!! __('post::publish.content', [
        'title' => $title,
    ], $locale) !!}
    <br>
    <a href="{{ $wpLink }}"> Wordpress Url</a>
@endsection
