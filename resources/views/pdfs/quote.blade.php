@extends('pdfs.layout')
<!-- Document title -->
@section('title', __('pdf.quote') . ' ' . $quote->number)
<!-- Barcode -->
@section('barcode')
    <!-- prettier-ignore -->
    <img src="data:image/png;base64, {{!! DNS2D::getBarcodePNG($quote->id, "QRCODE") !!}}" alt="barcode" width="100" height="100" style="margin-top: 10px"  />
@endsection

<!-- Content -->
@section('content')
    <div style="margin-top: 15px">
        <p>
            <strong>{{ __('pdf.number') }}</strong>
            {{ $quote->number }}
            <br />
            <strong>{{ __('pdf.date') }}</strong>
            {{ formatDateTime($quote->date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.due_date') }}</strong>
            {{ formatDateTime($quote->due_date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.currency') }}</strong>
            {{ $quote->currency }}
            <br />
            <strong>{{ __('pdf.status') }}</strong>

            @if ($quote->status == 'accepted')
                <span style="color: rgb(45, 173, 45)">{{ __('pdf.statuses.accepted') }}</span>
            @elseif ($quote->status == 'rejected')
                <span style="color: rgb(196, 41, 41)">{{ __('pdf.statuses.rejected') }}</span>
            @elseif ($quote->status == 'converted')
                <span style="color: rgb(35, 172, 30)">{{ __('pdf.statuses.converted') }}</span>
            @elseif ($quote->status == 'viewed')
                <span style="color: rgb(60, 140, 197)">{{ __('pdf.statuses.viewed') }}</span>
            @elseif ($quote->status == 'cancelled')
                <span style="color: rgb(49, 97, 129)">{{ __('pdf.statuses.cancelled') }}</span>
            @elseif ($quote->status == 'expired')
                <span style="color: rgb(196, 55, 55)">{{ __('pdf.statuses.expired') }}</span>
            @elseif ($quote->status == 'draft')
                <span style="color: rgb(219, 169, 75)">{{ __('pdf.statuses.draft') }}</span>
            @elseif ($quote->status == 'sent')
                <span style="color: rgb(74, 125, 190)">{{ __('pdf.statuses.sent') }}</span>
            @else
                <span style="color: rgb(105, 105, 188)">{{ __('pdf.statuses.other') }}</span>
            @endif
            <br />
            <strong>{{ __('pdf.payment_method') }}</strong>
            <span style="color: rgb(28, 118, 220)">{{ __('pdf.payment_methods.' . $quote->payment_method) }}</span>
        </p>
        <!-- Data about client and payer -->
        <table id="customer_payer_data" width="100%" style="margin-top: 20px">
            <tbody>
                <tr width="45%">
                    <td>
                        <p>
                            <strong>{{ __('pdf.customer') }}</strong>
                            <br />
                            @if ($quote->customer != null)
                                {{ $quote->customer_name }}
                                <br />
                                {{ $quote->customer_address }}
                                <br />
                                {{ $quote->customer_zip_code }} {{ $quote->customer_city }}
                                <br />
                                {{ $quote->customer_country }}
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
                            @if ($quote->payer != null)
                                {{ $quote->payer_name }}
                                <br />
                                {{ $quote->payer_address }}
                                <br />
                                {{ $quote->payer_zip_code }} {{ $quote->payer_city }}
                                <br />
                                {{ $quote->payer_country }}
                            @else
                                <span>{{ __('pdf.no_payer') }}</span>
                            @endif
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Table with items -->
        <table id="quote_items" class="items" width="100%">
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
                @foreach ($quote->items as $item)
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
        <table id="quote_footer" width="100%" style="margin-top: 20px">
            <tbody>
                <tr>
                    <td width="70%">
                        @if ($quote->footer != null)
                            <span><strong>{{ __('pdf.notes') }}</strong></span>
                            <br />
                            <span>{!! $quote->footer !!}</span>
                        @endif
                    </td>
                    <td width="30%">
                        @if ($quote->discount != null || $quote->discount >= 0)
                            <span><strong>{{ __('pdf.discount') }}</strong></span>
                            <br />
                            @if ($quote->discount_type == 'fixed')
                                {{ $quote->discount . ' ' . $quote->default_currency }}
                            @endif

                            @if ($quote->discount_type == 'percentage')
                                {{ $quote->discount . ' %' }}
                            @endif

                            <hr />
                        @endif

                        @if ($quote->currency_rate != 1)
                            <span>
                                <strong>{{ __('pdf.currency_rate') }}</strong>
                                1 {{ $quote->default_currency }} = {{ $quote->currency_rate }} {{ $quote->currency }}
                            </span>
                            <br />
                        @endif

                        <span>
                            <strong>{{ __('pdf.total_amount') }}</strong>
                            {{ formatMoney($quote->total, $quote->currency) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
