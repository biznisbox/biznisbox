@extends('emails.layout')
@section('content')
    <p>{{ __('email.hi_name', ['name' => $contact->name]) }}</p>
    <p>{{ __('email.new_invoice_created_for_you_or_your_company') }}</p>
    <p><b>{{ __('email.invoice_details') }}</b></p>

    <p>{{ __('email.invoice_number', ['number' => $invoice->number]) }}</p>
    <p>{{ __('email.invoice_date', ['date' => formatDateTime($invoice->date, $settings['date_format'])]) }}</p>
    <p>{{ __('email.due_date', ['date' => formatDateTime($invoice->due_date, $settings['date_format'])]) }}</p>
    <p>{{ __('email.amount', ['amount' => formatMoney($invoice->total, $invoice->currency)]) }}</p>

    <p>{{ __('email.click_on_the_button_below_to_view_invoice') }}</p>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
            <tr>
                <td align="left">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td><a href="{{ $url }}" target="_blank">{{ __('email.view_invoice') }}</a></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <p>{{ __('email.thank_you') }}</p>
@endsection
