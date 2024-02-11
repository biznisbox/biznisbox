@extends('emails.layout')
@section('content')
<p>Hi {{ $contact->name }},</p>

<p>New invoice has been created for you or your company.</p>

<p>Invoice Number: {{ $invoice->number }}</p>
<p>Invoice Date: {{ $invoice->date }}</p>
<p>Due Date: {{ $invoice->due_date }}</p>
<p>Amount: {{ $invoice->total . ' ' . $invoice->currency }}</p>

<p>Click on the button below to view or pay the invoice.</p>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
   <tbody>
      <tr>
         <td align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
               <tbody>
                  <tr>
                     <td> <a href="{{ $url }}" target="_blank">View Invoice</a> </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>

<p>Thank you for your business.</p>
<p>Regards,</p>
<p>{{ settings('company_name') }}</p>
@endsection