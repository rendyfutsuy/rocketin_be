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
    ], $lang) !!} </h4>
    {!! __('auth::email.change_password.content', [
        'lang' => $lang,
], $lang) !!}
@endsection
