<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.3;
            color: #333;
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
        }

        table th {
            text-align: left;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        #footer {
            position: fixed;
            left: 20px;
            bottom: 0;
        }

        #footer .page:after {
            content: counter(page);
        }
    </style>
</head>

<body>

    <div id="header">
        <table width="100%">
            <tr>
                <td width="75%">
                    <h1>
                        <h1>{{$document->name}}</h1>
                    </h1>
                </td>
                <td widht="15%" style="right: 0">
                    <div class="barcode" >
                        <img src="data:image/png;base64, {{!! base64_encode(Barcode2D::getBarcodeSVG($document->id, 'QRCODE')) !!}}" alt="barcode">
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Content -->
    <div id="estimate">
        <p>
            <strong>{{ __('pdf.document.number')}}</strong> {{ $document->number }}
            <br />
            <strong>{{ __('pdf.document.date')}}</strong> {{ format_datetime($document->date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.document.due_date')}}</strong> {{ format_datetime($document->due_date, settings('date_format')) }}
            <br />
            <strong>{{ __('pdf.document.version')}}</strong> {{ $document->version }}
            <br />

            <strong>{{ __('pdf.estimate.status')}}</strong>
            @if ($document->status == 'accepted')
                <span style="color: green;">{{ __('pdf.status.accepted')}}</span>
            @elseif($document->status == 'rejected')
                <span style="color: red;">{{ __('pdf.status.rejected')}}</span>
            @elseif($document->status == 'draft')
                <span style="color: grey;">{{ __('pdf.status.draft')}}</span>
            @elseif($document->status == 'pending')
                <span style="color: orange;">{{ __('pdf.status.pending')}}</span>
            @else
                <span style="color: blue;">{{ __('pdf.status.other')}}</span>
            @endif
            <br />
        </p>

        <div style="padding-top: 10px">
            {!!$document->content!!}
        </div>

    <!-- Footer -->
    <div id="footer">
        <p class="page"></p>
    </div>
</body>
</html>