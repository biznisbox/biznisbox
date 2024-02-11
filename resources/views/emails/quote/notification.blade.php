@extends('emails.layout')
@section('content')
<p>Hi {{ $contact->name }},</p>

<p>New quote has been created for you or your company.</p>

<p>Quote Number: {{ $quote->number }}</p>
<p>Quote Date: {{ $quote->date }}</p>
<p>Vaild Until: {{ $quote->valid_until }}</p>
<p>Total: {{ $quote->total . ' ' . $quote->currency }}</p>

<p>Click on the button below to view or accept the quote.</p>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
   <tbody>
      <tr>
         <td align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
               <tbody>
                  <tr>
                     <td> <a href="{{ $url }}" target="_blank">View Quote</a> </td>
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