@extends('emails.layout')
@section('content')
    <p>{{ __('email.hi_name', ['name' => $contact->signer_name]) }}</p>
    <p>{{ __('email.new_contract_created_for_you') }}</p>
    <p><b>{{ __('email.contract_details') }}</b></p>

    <p>{{ __('email.contract_number', ['number' => $contract->number]) }}</p>
    <p>{{ __('email.contract_expiry_date', ['date' => formatDateTime($contract->date_for_signature, $settings['date_format'])]) }}</p>

    <p>{{ __('email.click_on_the_button_below_to_sign_contract') }}</p>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
            <tr>
                <td align="left">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td><a href="{{ $url }}" target="_blank">{{ __('email.sign_contract') }}</a></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <p>{{ __('email.thank_you') }}</p>
@endsection
