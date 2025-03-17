@extends('emails.layout')
@section('content')
    <p>{{ __('email.hi_name', ['name' => $user->first_name . ' ' . $user->last_name]) }}</p>

    <p>{{ __('email.new_login_to_your_account') }}</p>

    <p><b>{{ __('email.login_details') }}</b></p>

    <p>{{ __('email.login_ip', ['ip' => $login->ip]) }}</p>

    <p>{{ __('email.login_browser', ['browser' => $login->browser]) }}</p>

    <p>{{ __('email.login_os', ['os' => $login->os]) }}</p>

    <p>{{ __('email.login_date', ['date' => now()]) }}</p>

    <p>{{ __('email.if_this_was_not_you') }}</p>
@endsection
