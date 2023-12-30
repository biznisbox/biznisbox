<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="{{ app()->getLocale() }}">
   <head>
      <meta http-equiv="Content-Type" content="charset=utf-8" />
      <style>
         @page {
         margin: 25px;
         }
         * {
         font-family: DejaVu Sans, sans-serif;
         font-size: 11px;
         line-height: 1.3;
         color: #333333;
         }
         h1 {
         font-size: 20px;
         margin: 0;
         }
         p {
         margin: 0;
         }
         table {
         width: 100%;
         max-width: 100%;
         margin-bottom: 20px;
         border-collapse: collapse;
         border-spacing: 0;
         }
         table th {
         text-align: left;
         }
         #footer {
         position: fixed;
         left: 25px;
         bottom: 0;
         }
         #footer .page:after {
         content: counter(page);
         }
         .barcode {
         right: 0;
         }
         table.items {
         width: 100%;
         border: 1px solid #ddd;
         }
         .items thead td {
         background-color: #f5f5f5;
         padding: 3px;
         border: #ddd;
         }
         .items tbody td {
         padding: 3px;
         border: #ddd;
         }
      </style>
   </head>
   <body>
      <div id="header">
         <table width="100%">
            <tr>
               <td width="90%">
                  <!-- Company details -->
                  <p>
                     <img src="{{ public_path(settings('company_logo')) }}" alt="Logo" width="40" height="auto" />
                     <br />
                     <strong>{{ settings('company_name') }}</strong>
                     <br />
                     @if(settings('company_address') != null)
                     <span >{{ settings('company_address') }}</span>
                     <br>
                     @endif
                     @if(settings('company_zip') != null && settings('company_city') != null)
                     <span>{{ settings('company_zip') . ' ' . settings('company_city') }}</span>
                     <br />
                     @endif
                     @if(settings('company_country') != null)
                     <span>{{ settings('company_country') }}</span>
                     <br />
                     @endif
                     <br />
                     @if(settings('company_vat') != null)
                     <strong>VAT </strong> {{ settings('company_vat') }}
                     <br />
                     @endif
                  </p>
               </td>
               <!-- Barcode -->
               @if(settings('show_barcode_on_documents') == true)
               <td widht="10%">
                  <div class="barcode">
                     @yield('barcode')
                  </div>
               </td>
               @endif
            </tr>
         </table>
         <!-- Title -->
         <h1>
            @yield('title')
         </h1>
      </div>
      <!-- Content -->
      @yield('content')
      <!-- Footer -->
      <div id="footer">
         <p class="page"></p>
      </div>
   </body>
</html>