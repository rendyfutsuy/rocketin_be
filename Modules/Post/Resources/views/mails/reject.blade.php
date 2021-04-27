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

    {!! __('post::reject.content', [
        'title' => $title,
    ], $locale) !!}

    @if ($note)
        {!! __('post::reject.note', [
            'note' => $note,
        ], $locale) !!}
    @endif
@endsection
