@extends('emails.layout')

@section('content')
<p>Hi</p>
<p>Thank you for your order. We have attached your estimate for your records.</p>


<p>Estimate Number: {{ $estimate->number }}</p>
<p>Estimate Date: {{format_datetime($estimate->date, settings('date_format'))  }}</p>
<p>Due Date: {{ format_datetime($estimate->due_date, settings('date_format')) }}</p>
<p>Status: {{ __('pdf.status.' . $estimate->status)  }}</p>
<p>Amount: {{ $estimate->total . ' '.  $estimate->currency }}</p>

<p><a href="{{ $link }}">Estimate Link</a></p>

<p>Please note that this is an estimate and not an invoice. If you would like to proceed with this order, please accept the estimate.</p>

<p>Thank you for your business.</p>

<p>Regards,</p>
<p>{{ settings('company_name') }}</p>
@endsection