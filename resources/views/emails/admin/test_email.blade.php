@extends('emails.layout')
@section('content')
    <p>{{ __('email.hi') }}</p>
    <p style="color: red">{{ __('email.this_is_a_test_email') }}</p>
    <p>{{ __('email.config_is_working') }}</p>
    <br />
@endsection
