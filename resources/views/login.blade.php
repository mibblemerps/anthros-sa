@extends('_template')

@section('head')
    <title>Not logged in - Anthros SA</title>

    <style>
        article {
            text-align: center;
            margin-top: 32px;
        }
    </style>
@endsection

@section('body')
    <article>
        <h1><i class="fa fa-warning"></i> Not Logged In</h1>
        <p>
            Please return to the Discord server and run <code>/photoupload</code>.
        </p>
    </article>
@endsection
