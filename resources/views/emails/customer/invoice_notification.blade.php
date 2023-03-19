@extends('emails.layout')

@section('content')
<p>Hi</p>
<p>Thank you for your order. We have attached your invoice for your records.</p>

<p>Invoice Number: {{ $invoice->number }}</p>
<p>Invoice Date: {{format_datetime($invoice->date, settings('date_format'))  }}</p>
<p>Due Date: {{ format_datetime($invoice->due_date, settings('date_format')) }}</p>
<p>Status: {{ __('pdf.status.' . $invoice->status)  }}</p>
<p>Amount: {{ $invoice->total . ' '.  $invoice->currency }}</p>

<p><a href="{{ $link }}">Invoice Link</a></p>

<p>Thank you for your business.</p>

<p>Regards,</p>
<p>{{ settings('company_name') }}</p>
@endsection