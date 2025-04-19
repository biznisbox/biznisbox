@extends('emails.layout')
@section('content')
    @if ($ticket->custom_contact)
        <p>{{ __('email.hi_name', ['name' => $ticket->contact_name]) }}</p>
    @else
        <p>{{ __('email.hi_name', ['name' => $contact->name]) }}</p>
    @endif
    <p>{{ __('email.new_support_ticket') }}</p>
    <p><b>{{ __('email.support_ticket_details') }}</b></p>

    <p>{{ __('email.support_ticket_number', ['number' => $ticket->number]) }}</p>
    <p>{{ __('email.support_ticket_subject', ['subject' => $ticket->subject]) }}</p>
    <p>{{ __('email.support_ticket_status', ['status' => $ticket->status]) }}</p>

    <p>{{ __('email.click_on_the_button_below_to_view_ticket') }}</p>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
            <tr>
                <td align="left">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td><a href="{{ $url }}" target="_blank">{{ __('email.view_ticket') }}</a></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <p>{{ __('email.thank_you') }}</p>
@endsection
