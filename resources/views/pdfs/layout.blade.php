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
                <td width="90%">
                    <h1>
                        @yield('title')
                    </h1>
                </td>
                <td widht="10%">
                    <div class="barcode">
                        @yield('barcode')
                    </div>
                </td>
            </tr>
        </table>

        <!-- Data about company -->
        <p>
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
    </div>

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <div id="footer">
        <p class="page"></p>
    </div>
</body>

</html>