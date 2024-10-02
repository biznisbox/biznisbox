@extends('pdfs.layout')
<!-- Document title -->
@section('title', __('pdf.contract') . ' ' . $contract->number)
<!-- Barcode -->
@section('barcode')
    <!-- prettier-ignore -->
    <img src="data:image/png;base64, {{!! DNS2D::getBarcodePNG($contract->id, 'QRCODE') !!}}"  alt="barcode"  width="100"  height="100"  style="margin-top: 10px"  />
@endsection

<!-- Content -->
@section('content')
    <div style="margin-top: 15px">
        <p>
            <strong>{{ __('pdf.number') }}</strong>
            {{ $contract->number }}
            <br />
            <strong>{{ __('pdf.status') }}</strong>

            @if ($contract->status == 'signed')
                <span style="color: rgb(45, 173, 45)">{{ __('pdf.statuses.signed') }}</span>
            @elseif ($contract->status == 'rejected')
                <span style="color: rgb(196, 41, 41)">{{ __('pdf.statuses.rejected') }}</span>
            @elseif ($contract->status == 'expired')
                <span style="color: rgb(170, 50, 50)">{{ __('pdf.statuses.expired') }}</span>
            @elseif ($contract->status == 'waiting_signers')
                <span style="color: rgb(216, 202, 0)">{{ __('pdf.statuses.waiting_signers') }}</span>
            @elseif ($contract->status == 'cancelled')
                <span style="color: rgb(49, 97, 129)">{{ __('pdf.statuses.cancelled') }}</span>
            @elseif ($contract->status == 'draft')
                <span style="color: rgb(219, 169, 75)">{{ __('pdf.statuses.draft') }}</span>
            @else
                <span style="color: rgb(105, 105, 188)">{{ __('pdf.statuses.other') }}</span>
            @endif
        </p>

        <!-- Contract content -->
        <span style="color: rgb(28, 118, 220)">{{ __('pdf.contract') }}</span>
        <br />
        <div id="contract_content" style="margin-top: 5px">
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
    </div>
@endsection
