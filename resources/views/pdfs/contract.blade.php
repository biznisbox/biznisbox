@extends('pdfs.layout')

<!-- Document title -->
@section('title')
<span style="color: rgb(28, 118, 220); font-size: 18px; font-weight: bold;">
    {{ $contract->title }}
</span>
@endsection

<!-- Barcode -->
@section('barcode')
    {!! DNS2D::getBarcodeHtml($contract->id, 'QRCODE', 3, 3) !!}
@endsection

<!-- Content -->
@section('content')
    <div style="margin-top: 15px">
        <p>
            <strong>{{ __('pdf.number') }}</strong>
            {{ $contract->number }}
        </p>
    </div>

    <!-- Contract Content -->
    <div id="contract_content" style="margin-top: 15px">
            {!! $contract->content !!}
    </div>

    <!-- Signers -->
   <span style="color: rgb(28, 118, 220);">{{ __('pdf.signers') }}</span>

        <table id="signers" width="100%">
            <thead>
                <tr>
                    <th>{{ __('pdf.name') }}</th>
                    <th>{{ __('pdf.email') }}</th>
                    <th>{{ __('pdf.signature') }}</th>
                    <th>{{ __('pdf.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contract->signers as $signer)
                    <tr>
                        <td>{{ $signer->signer_name }}</td>
                        <td>{{ $signer->signer_email }}</td>
                        <td>
                            @if ($signer->signature != null)
                                <img src="{{ $signer->signature }}" alt="signature" width="250" height="100" />
                            @else
                                <span style="color: rgb(49, 97, 129)">{{ __('pdf.no_signature') }}</span>
                            @endif
                        </td>
                        <td>
                            @if ($signer->status == 'signed')
                                <span style="color: rgb(45, 173, 45)">{{ __('pdf.statuses.signed') }}</span>
                            @elseif ($signer->status == 'rejected')
                                <span style="color: rgb(196, 41, 41)">{{ __('pdf.statuses.rejected') }}</span>
                            @elseif ($signer->status == 'waiting_signature')
                                <span style="color: rgb(216, 202, 0)">{{ __('pdf.statuses.waiting_signature') }}</span>
                            @else
                                <span style="color: rgb(105, 105, 188)">{{ __('pdf.statuses.other') }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
