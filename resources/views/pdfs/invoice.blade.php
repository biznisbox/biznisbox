@extends('pdfs.layout')

<style>
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

        #customer_payer_data {
            margin-top: 10px;
        }

        #invoice {
            margin-top: 10px;
        }

        .barcode {
            right: 0;
        }
</style>

<!-- Document title -->
@section('title', __('pdf.invoice.title'))

<!-- Barcode -->
@section('barcode')
        <img src="data:image/png;base64, {{!! base64_encode(Barcode2D::getBarcodeSVG($invoice->id, 'QRCODE')) !!}}" alt="barcode">
@endsection

<!-- Content -->
@section('content')
    <div id="invoice">
        <p>
            <strong>{{ __('pdf.invoice.number')}}</strong> {{ $invoice->number }}
            <br />
            <strong>{{ __('pdf.invoice.date')}}</strong> {{ format_datetime($invoice->date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.invoice.due_date')}}</strong> {{ format_datetime($invoice->due_date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.invoice.status')}}</strong>
            @if ($invoice->status == 'paid')
                <span style="color: green;">Paid</span>
            @elseif($invoice->status == 'unpaid')
                <span style="color: red;">{{ __('pdf.status.unpaid')}}</span>
            @elseif($invoice->status == 'overdue')
                <span style="color: red;">{{ __('pdf.status.overdue')}}</span>
            @elseif($invoice->status == 'partially_paid')
                <span style="color: yellow;">{{ __('pdf.status.partially_paid')}}</span>
            @elseif($invoice->status == 'cancelled')
                <span style="color: grey;">{{ __('pdf.status.cancelled')}}</span>
            @elseif($invoice->status == 'draft')
                <span style="color: orange;">{{ __('pdf.status.draft')}}</span>
            @else
                <span style="color: blue;">{{ __('pdf.status.other') }}</span>
            @endif
            <br />
            <strong>{{ __('pdf.invoice.payment_method')}}</strong>
            @if ($invoice->payment_method == 'bank_transfer')
                <span style="color: blue;">{{ __('pdf.payment_method.bank_transfer') }}</span>
            @elseif($invoice->payment_method == 'cash')
                <span style="color: blue;">{{ __('pdf.payment_method.cash') }}</span>
            @elseif($invoice->payment_method == 'bank_card')
                <span style="color: blue;">{{ __('pdf.payment_method.bank_card') }}</span>
            @elseif($invoice->payment_method == 'paypal')
                <span style="color: blue;">{{ __('pdf.payment_method.paypal') }}</span>
            @else
                <span style="color: blue;">{{ __('pdf.payment_method.other') }}</span>  
            @endif
        </p>
        <!-- Data about client and payer -->
        <table id="customer_payer_data" width="100%">
            <tbody>
                <tr width="45%">
                    <td>
                        <p>
                            <strong>{{ __('pdf.invoice.customer')}}</strong>
                            <br />
                            @if ($invoice->customer != null)
                                {{ $invoice->customer_name }}
                                <br />
                                {{ $invoice->customer_address }}
                                <br />
                                {{ $invoice->customer_zip_code }} {{ $invoice->customer_city }}
                                <br />
                                {{ $invoice->customer_country }}
                            @else
                                <span>{{ __('pdf.invoice.no_customer')}}</span>
                            @endif
                        </p>
                    </td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">
                        <p>
                            <strong>{{ __('pdf.invoice.payer')}}</strong>
                            <br />
                            @if ($invoice->payer != null)
                                {{ $invoice->payer_name }}
                                <br />
                                {{ $invoice->payer_address }}
                                <br />
                                {{ $invoice->payer_zip_code }} {{ $invoice->payer_city }}
                                <br />
                                {{ $invoice->payer_country }}
                            @else
                                <span>{{ __('pdf.invoice.no_payer')}}</span>
                            @endif
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Table with items -->

        <table id="invoice_items" class="items" width="100%">
            <thead>
                <tr>
                    <td width="20%"><strong>{{ __('pdf.invoice.name')}}</strong></td>
                    <td width="20%"><strong>{{ __('pdf.invoice.description')}}</strong></td>
                    <td width="10%"><strong>{{ __('pdf.invoice.price')}} ({{ settings('default_currency') }})</strong></td>
                    <td width="10%"><strong>{{ __('pdf.invoice.quantity')}}</strong></td>
                    <td width="10%"><strong>{{ __('pdf.invoice.tax')}}</strong></td>
                    <td with="10%"><strong>{{ __('pdf.invoice.discount')}}</strong></td>
                    <td width="10%"><strong>{{ __('pdf.invoice.total')}} ({{ settings('default_currency') }})</strong></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['description'] }}</td>
                        <td>{{ $item['price'] . ' ' . settings('default_currency') }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['tax'] . ' %' }}</td>
                        <td>{{ $item['discount'] . ' %' }}</td>
                        <td>{{ $item['total'] . ' ' . settings('default_currency') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Table with totals -->
        <!-- Total price -->
        <table id="invoice_footer" width="100%" style="margin-top: 20px">
            <tbody>
                <tr>
                    <td width="70%">
                        @if ($invoice->footer != null)
                            <span><strong>{{ __('pdf.invoice.notes')}}</strong></span>
                            <br />
                            <span>{!! $invoice->footer !!}</span>
                        @endif
                    </td>
                    <td width="30%" align="right" style="vertical-align:top">
                        <span> <strong>{{ __('pdf.invoice.discount')}}</strong> {{ $invoice->discount . ' %' }}</span>
                        <hr />
                        @if ($invoice->currency_rate != 1)
                        <span><strong>{{ __('pdf.invoice.currency_rate')}}</strong> {{ $invoice->currency_rate }}</span>
                        @endif
                        <span><strong>{{ __('pdf.invoice.total_amount')}}</strong> {{ $invoice->total . ' ' . $invoice->currency }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection