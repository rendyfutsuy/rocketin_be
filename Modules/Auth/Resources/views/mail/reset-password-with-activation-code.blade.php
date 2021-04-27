@extends('auth::mail.layout')

@section('content')
    <style>
        .submit:hover {
            opacity: 0.7;
            transition: 0.3s;
        }

        .submit {
            color: #000;
            text-align:center;
            padding: 10px;
            border: 1px #f0f0f0 solid;
            border-radius: 10px;
            width: 175px;
            margin: auto;
            color: #ffffff;
            background: #2453FF;
        }

    </style>

    <h4> {!! __('auth::email.layout.title_2', [
        'username' => $userName
    ], $lang) !!} </h4>
    {!! __('auth::email.reset_password.content', [
        'lang' => $lang,
        'urlResetForm' => $resetFormLink,
], $lang) !!}
@endsection
