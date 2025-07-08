@extends('emails.layout')
@section('content')
    <p>{{ __('email.hi_name', ['name' => $partner_contact->name]) }}</p>
    <p>{{ __('email.new_user_for_client_portal') }}</p>

    <p><b>{{ __('email.client_portal_details') }}</b></p>

    <p>{{ __('email.client_portal_email', ['email' => $partner_contact->email]) }}</p>
    <p>{{ __('email.client_portal_password') }} {{ $password }}</p>

    <p>{{ __('email.click_on_the_button_below_to_login') }}</p>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
            <tr>
                <td align="left">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td><a href="{{ $url }}" target="_blank">{{ __('email.login_to_client_portal') }}</a></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <p>{{ __('email.thank_you') }}</p>
@endsection
