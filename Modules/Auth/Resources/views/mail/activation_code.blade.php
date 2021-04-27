@extends('auth::mail.layout')

@section('content')
    {!! __('auth::email.activation.content', [
        'activationCode' => $activationCode,
        'lang' => $lang,
], $lang) !!}
@endsection