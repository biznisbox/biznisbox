@extends('emails.layout')

@section('content')
    <p>Hi,</p>
    <p>A user account was created today.</p>

    <p>Here are the details:</p>

    <p>Username: {{ $user['email'] }}</p>
    <p>Password: {{ $user['password'] }}</p>

    <a href="{{ $url }}">For login use this link. </a>
    <p>Regards,</p>
    <p>{{ $app }}</p>
@endsection