@extends('pdfs.layout')
<!-- Document title -->
@section('title', __('pdf.invoice') . ' ' . $invoice->number)
<!-- Barcode -->
@section('barcode')
    {!! DNS2D::getBarcodeHtml($invoice->id, 'QRCODE', 3, 3) !!}
@endsection

<!-- Content -->
@section('content')
    <div style="margin-top: 15px">
        <p>
            <strong>{{ __('pdf.number') }}</strong>
            {{ $invoice->number }}
            <br />
            <strong>{{ __('pdf.date') }}</strong>
            {{ formatDateTime($invoice->date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.due_date') }}</strong>
            {{ formatDateTime($invoice->due_date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.currency') }}</strong>
            {{ $invoice->currency }}
            <br />
            <strong>{{ __('pdf.status') }}</strong>

            @if ($invoice->status == 'paid')
                <span style="color: rgb(45, 173, 45)">{{ __('pdf.statuses.paid') }}</span>
            @elseif ($invoice->status == 'unpaid')
                <span style="color: rgb(196, 41, 41)">{{ __('pdf.statuses.unpaid') }}</span>
            @elseif ($invoice->status == 'overdue')
                <span style="color: rgb(170, 50, 50)">{{ __('pdf.statuses.overdue') }}</span>
            @elseif ($invoice->status == 'partially_paid')
                <span style="color: rgb(216, 202, 0)">{{ __('pdf.statuses.partially_paid') }}</span>
            @elseif ($invoice->status == 'cancelled')
                <span style="color: rgb(49, 97, 129)">{{ __('pdf.statuses.cancelled') }}</span>
            @elseif ($invoice->status == 'refunded')
                <span style="color: rgb(105, 155, 188)">{{ __('pdf.statuses.refunded') }}</span>
            @elseif ($invoice->status == 'overpaid')
                <span style="color: rgb(32, 100, 57)">{{ __('pdf.statuses.overpaid') }}</span>
            @elseif ($invoice->status == 'draft')
                <span style="color: rgb(219, 169, 75)">{{ __('pdf.statuses.draft') }}</span>
            @else
                <span style="color: rgb(105, 105, 188)">{{ __('pdf.statuses.other') }}</span>
            @endif
            <br />
            <strong>{{ __('pdf.payment_method') }}</strong>
            @if ($invoice->paymentMethod == null)
                <span style="color: rgb(41, 147, 196)">{{ __('pdf.no_payment_method') }}</span>
            @endif
            @if ($invoice->paymentMethod != null)
                <span style="color: rgb(28, 118, 220)">{{ __('pdf.payment_methods.' . $invoice->paymentMethod->additional_info) }}</span>
            @endif
        </p>
        <!-- Data about client and payer -->
        <table id="customer_payer_data" width="100%" style="margin-top: 20px">
            <tbody>
                <tr width="45%">
                    <td>
                        <p>
                            <strong>{{ __('pdf.customer') }}</strong>
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
                                <span>{{ __('pdf.no_customer') }}</span>
                            @endif
                        </p>
                    </td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">
                        <p>
                            <strong>{{ __('pdf.payer') }}</strong>
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
                                <span>{{ __('pdf.no_payer') }}</span>
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
                    <td width="20%"><strong>{{ __('pdf.product_name') }}</strong></td>
                    <td width="20%"><strong>{{ __('pdf.description') }}</strong></td>
                    <td width="10%"><strong>{{ __('pdf.price') }} ({{ $settings['default_currency'] }})</strong></td>
                    <td width="10%"><strong>{{ __('pdf.quantity') }}</strong></td>
                    <td width="10%"><strong>{{ __('pdf.tax') }}</strong></td>
                    <td with="10%"><strong>{{ __('pdf.discount') }}</strong></td>
                    <td width="10%"><strong>{{ __('pdf.total') }} ({{ $settings['default_currency'] }})</strong></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td style="word-break: break-word">{{ $item['name'] }}</td>
                        <td style="word-break: break-word">{{ $item['description'] }}</td>
                        <td style="word-break: break-word">{{ formatMoney($item['price'], $settings['default_currency']) }}</td>
                        <td style="word-break: break-word">{{ $item['quantity'] . ' '. $item['unit'] }}</td>
                        <td style="word-break: break-word">{{ $item['tax'] . ' %' }}</td>
                        <td style="word-break: break-word">{{ $item['discount'] . ' %' }}</td>
                        <td style="word-break: break-word">{{ formatMoney($item['total'], $settings['default_currency']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table id="invoice_footer" width="100%" style="margin-top: 20px">
            <tbody>
                <tr>
                    <td width="70%">
                        @if ($invoice->footer != null)
                            <span><strong>{{ __('pdf.notes') }}</strong></span>
                            <br />
                            <span>{!! $invoice->footer !!}</span>
                        @endif
                    </td>
                    <td width="30%">
                        @if ($invoice->discount != null || $invoice->discount >= 0)
                            <span><strong>{{ __('pdf.discount') }}</strong></span>
                            @if ($invoice->discount_type == 'fixed')
                                {{ $invoice->discount . ' ' . $invoice->default_currency }}
                            @endif

                            @if ($invoice->discount_type == 'percent')
                                {{ $invoice->discount . ' %' }}
                            @endif

                            <hr />
                        @endif

                        @if ($invoice->currency_rate != 1)
                            <span>
                                <strong>{{ __('pdf.currency_rate') }}</strong>
                                1 {{ $invoice->default_currency }} = {{ $invoice->currency_rate }} {{ $invoice->currency }}
                            </span>
                            <br />
                        @endif

                        @if ($invoice->tax_calculation && count($invoice->tax_calculation) > 0)
                            <span>
                                <strong>{{ __('pdf.tax_amount') }}</strong>
                                @foreach ($invoice->tax_calculation as $tax)
                                <span>
                                <p>{{ $tax['name'] }}:</p>
                                    {{ formatMoney($tax['amount'], $invoice->currency) }}
                                </span>
                                @endforeach
                            </span>
                            <hr />
                            <br />
                        @endif

                        <span>
                            <strong>{{ __('pdf.total_amount') }}</strong>
                            {{ formatMoney($invoice->total, $invoice->currency) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
