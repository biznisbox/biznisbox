@extends('emails.layout')
@section('content')
<p>Hi {{ $user->name }},</p>
<p>You are receiving this email because you (or someone else) have requested the reset of the password for your account.</p>
<p>Please click on the button below to reset your password:</p>
<br />
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
   <tbody>
      <tr>
         <td align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
               <tbody>
                  <tr>
                     <td> <a href="{{ $url }}" target="_blank">Reset Password</a> </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<p>If you did not request a password reset, no further action is required.</p>
@endsection