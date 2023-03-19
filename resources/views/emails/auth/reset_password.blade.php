@extends('emails.layout')

@section('content')
    <p>Hi {{ $user->name }},</p>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p><a href="{{ $url }}">Reset Password</a></p>
    <p>If you did not request a password reset, no further action is required.</p>
@endsection