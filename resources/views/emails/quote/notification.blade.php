@extends('emails.layout')
@section('content')
    <p>{{ __('email.hi_name', ['name' => $contact->name]) }}</p>

    <p>{{ __('email.new_quote_created_for_you_or_your_company') }}</p>

    <p><b>{{ __('email.quote_details') }}</b></p>

    <p>{{ __('email.quote_number', ['number' => $quote->number]) }}</p>
    <p>{{ __('email.quote_date', ['date' => formatDateTime($quote->date, $settings['date_format'])]) }}</p>
    <p>{{ __('email.valid_until', ['date' => formatDateTime($quote->valid_until, $settings['date_format'])]) }}</p>
    <p>{{ __('email.amount', ['amount' => formatMoney($quote->total, $quote->currency)]) }}</p>

    <p>{{ __('email.click_on_the_button_below_to_view_quote') }}</p>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
            <tr>
                <td align="left">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td><a href="{{ $url }}" target="_blank">{{ __('email.view_quote') }}</a></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <p>{{ __('email.thank_you') }}</p>
@endsection
