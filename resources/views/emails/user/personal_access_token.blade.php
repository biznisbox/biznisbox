@extends('emails.layout')
@section('content')
    <p>{{ __('email.hi_name', ['name' => $user->first_name . ' ' . $user->last_name]) }}</p>

    <p>{{ __('email.new_personal_access_token_generated') }}</p>

    <h2><strong>{{ __('email.personal_access_token_details') }}</strong></h2>

    <p>
        <strong>{{ __('email.personal_access_token_name') }}</strong>
        {{ $token->name }}
    </p>

    <p>
        <strong>{{ __('email.personal_access_token_valid_until') }}</strong>
        {{ formatDateTime($token->valid_until, settings('datetime_format')) }}
    </p>

    <p>{{ __('email.if_this_was_not_you_personal_access_token') }}</p>
@endsection
