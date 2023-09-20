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

        #quote {
            margin-top: 10px;
        }

        .barcode {
            right: 0;
        }
</style>

<!-- Document title -->
@section('title', __('pdf.quote.title'))

<!-- Barcode -->
@section('barcode')
        <img src="data:image/png;base64, {{!! base64_encode(Barcode2D::getBarcodeSVG($quote->id, 'QRCODE')) !!}}" alt="barcode">
@endsection

<!-- Content -->
@section('content')
    <div id="quote">
        <p>
            <strong>{{ __('pdf.quote.number')}}</strong> {{ $quote->number }}
            <br />
            <strong>{{ __('pdf.quote.date')}}</strong> {{ format_datetime($quote->date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.quote.valid_until')}}</strong> {{ format_datetime($quote->valid_until, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.quote.status')}}</strong>
            @if ($quote->status == 'accepted')
                <span style="color: green;">{{ __('pdf.status.accepted')}}</span>
            @elseif($quote->status == 'rejected')
                <span style="color: red;">{{ __('pdf.status.rejected')}}</span>
            @elseif($quote->status == 'cancelled')
                <span style="color: grey;">{{ __('pdf.status.cancelled')}}</span>
            @elseif($quote->status == 'draft')
                <span style="color: orange;">{{ __('pdf.status.draft')}}</span>
            @else
                <span style="color: blue;">{{ __('pdf.status.other')}}</span>
            @endif
            <br />
        </p>
        <!-- Data about client and payer -->
        <table id="customer_payer_data" width="100%">
            <tbody>
                <tr width="45%">
                    <td>
                        <p>
                            <strong>{{ __('pdf.quote.customer')}}</strong>
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
                                <span>{{ __('pdf.quote.no_customer')}}</span>
                            @endif
                        </p>
                    </td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">
                        <p>
                            <strong>{{ __('pdf.quote.payer')}}</strong>
                            <br />
                            @if ($quote->payer != null)
                                {{ $quote->payer->name }}
                                <br />
                                {{ $quote->payer_address }}
                                <br />
                                {{ $quote->payer_zip_code }} {{ $quote->payer_city }}
                                <br />
                                {{ $quote->payer_country }}
                            @else
                                <span>{{ __('pdf.quote.no_payer')}}</span>
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
                    <td width="20%"><strong>{{ __('pdf.quote.name')}}</strong></td>
                    <td width="20%"><strong>{{ __('pdf.quote.description')}}</strong></td>
                    <td width="10%"><strong>{{ __('pdf.quote.price')}} ({{ settings('default_currency') }})</strong></td>
                    <td width="10%"><strong>{{ __('pdf.quote.quantity')}}</strong></td>
                    <td width="10%"><strong>{{ __('pdf.quote.discount')}}</strong></td>	
                    <td width="10%"><strong>{{ __('pdf.quote.total')}} ({{ settings('default_currency') }})</strong></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($quote->items as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['description'] }}</td>
                        <td>{{ $item['price'] . ' ' .  settings('default_currency')}}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['discount'] . ' %' }}</td>
                        <td>{{ $item['total'] . ' ' . settings('default_currency') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Table with totals -->
        <!-- Total price -->
        <table id="quote_footer" width="100%" style="margin-top: 20px">
            <tbody>
                <tr>
                    <td width="70%">
                        @if ($quote->footer != null)
                            <span><strong>{{ __('pdf.quote.notes')}}</strong></span>
                            <br />
                            <span>{!! $quote->footer !!}</span>
                        @endif
                    </td>
                    <td width="30%" align="right" style="vertical-align:top">
                        <span> <strong>{{ __('pdf.quote.discount')}}</strong> {{ $quote->discount . ' %' }}</span>
                        <hr />
                        <span><strong>{{ __('pdf.quote.total_amount')}}</strong> {{ $quote->total . ' ' . $quote->currency }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection