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

        #estimate {
            margin-top: 10px;
        }

        .barcode {
            right: 0;
        }
</style>

<!-- Document title -->
@section('title', __('pdf.estimate.title'))

<!-- Barcode -->
@section('barcode')
        <img src="data:image/png;base64, {{!! base64_encode(Barcode2D::getBarcodeSVG($estimate->id, 'QRCODE')) !!}}" alt="barcode">
@endsection

<!-- Content -->
@section('content')
    <div id="estimate">
        <p>
            <strong>{{ __('pdf.estimate.number')}}</strong> {{ $estimate->number }}
            <br />
            <strong>{{ __('pdf.estimate.date')}}</strong> {{ format_datetime($estimate->date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.estimate.valid_until')}}</strong> {{ format_datetime($estimate->valid_until, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.estimate.status')}}</strong>
            @if ($estimate->status == 'accepted')
                <span style="color: green;">{{ __('pdf.status.accepted')}}</span>
            @elseif($estimate->status == 'rejected')
                <span style="color: red;">{{ __('pdf.status.rejected')}}</span>
            @elseif($estimate->status == 'cancelled')
                <span style="color: grey;">{{ __('pdf.status.cancelled')}}</span>
            @elseif($estimate->status == 'draft')
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
                            <strong>{{ __('pdf.estimate.customer')}}</strong>
                            <br />
                            @if ($estimate->customer != null)
                                {{ $estimate->customer_name }}
                                <br />
                                {{ $estimate->customer_address }}
                                <br />
                                {{ $estimate->customer_zip_code }} {{ $estimate->customer_city }}
                                <br />
                                {{ $estimate->customer_country }}
                            @else
                                <span>{{ __('pdf.estimate.no_customer')}}</span>
                            @endif
                        </p>
                    </td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">
                        <p>
                            <strong>{{ __('pdf.estimate.payer')}}</strong>
                            <br />
                            @if ($estimate->payer != null)
                                {{ $estimate->payer->name }}
                                <br />
                                {{ $estimate->payer_address }}
                                <br />
                                {{ $estimate->payer_zip_code }} {{ $estimate->payer_city }}
                                <br />
                                {{ $estimate->payer_country }}
                            @else
                                <span>{{ __('pdf.estimate.no_payer')}}</span>
                            @endif
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Table with items -->

        <table id="estimate_items" class="items" width="100%">
            <thead>
                <tr>
                    <td width="20%"><strong>{{ __('pdf.estimate.name')}}</strong></td>
                    <td width="20%"><strong>{{ __('pdf.estimate.description')}}</strong></td>
                    <td width="10%"><strong>{{ __('pdf.estimate.price')}} ({{ $estimate->currency }})</strong></td>
                    <td width="10%"><strong>{{ __('pdf.estimate.quantity')}}</strong></td>
                    <td width="10%"><strong>{{ __('pdf.estimate.discount')}}</strong></td>	
                    <td width="10%"><strong>{{ __('pdf.estimate.total')}} ({{ $estimate->currency }})</strong></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($estimate->items as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['description'] }}</td>
                        <td>{{ $item['price'] . ' ' . $estimate->currency }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['discount'] . ' %' }}</td>
                        <td>{{ $item['total'] . ' ' . $estimate->currency }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Table with totals -->
        <!-- Total price -->
        <table id="estimate_footer" width="100%" style="margin-top: 20px">
            <tbody>
                <tr>
                    <td width="70%">
                        @if ($estimate->footer != null)
                            <span><strong>{{ __('pdf.estimate.notes')}}</strong></span>
                            <br />
                            <span>{!! $estimate->footer !!}</span>
                        @endif
                    </td>
                    <td width="30%" align="right" style="vertical-align:top">
                        <span> <strong>{{ __('pdf.estimate.discount')}}</strong> {{ $estimate->discount . ' %' }}</span>
                        <hr />
                        <span><strong>{{ __('pdf.estimate.total_amount')}}</strong> {{ $estimate->total . ' ' . $estimate->currency }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection