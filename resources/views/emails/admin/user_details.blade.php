@extends('emails.layout')
@section('content')
    <p>{{ __('email.hi') }}</p>
    <p><b>{{ __('email.user_details') }}</b></p>
    <p>
        <b>{{ __('email.name') }}:</b>
        {{ $user->first_name }} {{ $user->last_name }}
    </p>
    <p>
        <b>{{ __('email.email') }}:</b>
        {{ $user->email }}
    </p>
    @if ($password)
        <p>
            <b>{{ __('email.password') }}:</b>
            {{ $password }}
        </p>
    @endif

    <p>{{ __('email.click_on_the_button_below_to_login') }}</p>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
            <tr>
                <td align="left">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td><a href="{{ url('auth/login') }}" target="_blank">{{ __('email.login') }}</a></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
