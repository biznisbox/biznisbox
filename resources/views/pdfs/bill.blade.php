@extends('pdfs.layout')
<!-- Document title -->
@section('title', __('pdf.bill') . ' ' . $bill->number)
<!-- Barcode -->
@section('barcode')
    <!-- prettier-ignore -->
    {!! DNS2D::getBarcodeHtml($bill->id, 'QRCODE', 3, 3) !!}
@endsection

<!-- Content -->
@section('content')
    <div style="margin-top: 15px">
        <p>
            <strong>{{ __('pdf.number') }}</strong>
            {{ $bill->number }}
            <br />
            <strong>{{ __('pdf.date') }}</strong>
            {{ formatDateTime($bill->date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.due_date') }}</strong>
            {{ formatDateTime($bill->due_date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.currency') }}</strong>
            {{ $bill->currency }}
            <br />
            <strong>{{ __('pdf.status') }}</strong>

            @if ($bill->status == 'paid')
                <span style="color: rgb(45, 173, 45)">{{ __('pdf.statuses.paid') }}</span>
            @elseif ($bill->status == 'unpaid')
                <span style="color: rgb(196, 41, 41)">{{ __('pdf.statuses.unpaid') }}</span>
            @elseif ($bill->status == 'overdue')
                <span style="color: rgb(170, 50, 50)">{{ __('pdf.statuses.overdue') }}</span>
            @elseif ($bill->status == 'partially_paid')
                <span style="color: rgb(216, 202, 0)">{{ __('pdf.statuses.partially_paid') }}</span>
            @elseif ($bill->status == 'cancelled')
                <span style="color: rgb(49, 97, 129)">{{ __('pdf.statuses.cancelled') }}</span>
            @elseif ($bill->status == 'refunded')
                <span style="color: rgb(105, 155, 188)">{{ __('pdf.statuses.refunded') }}</span>
            @elseif ($bill->status == 'overpaid')
                <span style="color: rgb(32, 100, 57)">{{ __('pdf.statuses.overpaid') }}</span>
            @elseif ($bill->status == 'draft')
                <span style="color: rgb(219, 169, 75)">{{ __('pdf.statuses.draft') }}</span>
            @else
                <span style="color: rgb(105, 105, 188)">{{ __('pdf.statuses.other') }}</span>
            @endif
            <br />
            @if($bill->payment_method != null)
            <strong>{{ __('pdf.payment_method') }}</strong>
            <span style="color: rgb(28, 118, 220)">{{ __('pdf.payment_methods.' . $bill->payment_method) }}</span>
            <br />
            @endif
            @if($bill->reference != null)
            <strong>{{ __('pdf.reference') }}</strong>
            {{ $bill->reference }}
            <br />
            @endif
        </p>
        <!-- Data about supplier -->
        <table id="supplier_data" width="100%" style="margin-top: 20px">
            <tbody>
                <tr width="45%">
                    <td>
                        <p>
                            <strong>{{ __('pdf.supplier') }}</strong>
                            <br />
                            @if ($bill->supplier_id != null)
                                {{ $bill->supplier_name }}
                                <br />
                                {{ $bill->supplier_address }}
                                <br />
                                {{ $bill->supplier_zip_code }} {{ $bill->supplier_city }}
                                <br />
                                {{ $bill->supplier_country }}
                            @else
                                <span>{{ __('pdf.no_supplier') }}</span>
                            @endif
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Table with items -->
        <table id="bill_items" class="items" width="100%">
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
                @foreach ($bill->items as $item)
                    <tr>
                        <td style="word-break: break-word">{{ $item['name'] }}</td>
                        <td style="word-break: break-word">{{ $item['description'] }}</td>
                        <td style="word-break: break-word">{{ formatMoney($item['price'], $settings['default_currency']) }}</td>
                        <td style="word-break: break-word">{{ $item['quantity'] . ' '. $item['unit']}}</td>
                        <td style="word-break: break-word">{{ $item['tax'] . ' %' }}</td>
                        <td style="word-break: break-word">{{ $item['discount'] . ' %' }}</td>
                        <td style="word-break: break-word">{{ formatMoney($item['total'], $settings['default_currency']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table id="bill_footer" width="100%" style="margin-top: 20px">
            <tbody>
                <tr>
                    <td width="70%">
                        @if ($bill->footer != null)
                            <span><strong>{{ __('pdf.notes') }}</strong></span>
                            <br />
                            <span>{!! $bill->footer !!}</span>
                        @endif
                    </td>
                    <td width="30%">
                        @if ($bill->discount != null || $bill->discount >= 0)
                            <span><strong>{{ __('pdf.discount') }}</strong></span>
                            <br />
                            @if ($bill->discount_type == 'fixed')
                                {{ $bill->discount . ' ' . $bill->default_currency }}
                            @endif

                            @if ($bill->discount_type == 'percentage')
                                {{ $bill->discount . ' %' }}
                            @endif

                            <hr />
                        @endif

                        @if ($bill->currency_rate != 1)
                            <span>
                                <strong>{{ __('pdf.currency_rate') }}</strong>
                                1 {{ $bill->default_currency }} = {{ $bill->currency_rate }} {{ $bill->currency }}
                            </span>
                            <br />
                        @endif

                        <span>
                            <strong>{{ __('pdf.total_amount') }}</strong>
                            {{ formatMoney($bill->total, $bill->currency) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
