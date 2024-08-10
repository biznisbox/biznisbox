<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="charset=utf-8" />
        <title>{{ $settings['company_name'] }}</title>
        <style>
            @page {
                margin: 25px;
            }

            * {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                line-height: 1.5;
                color: #333333;
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
                border-collapse: collapse;
                border-spacing: 0;
            }

            table th {
                text-align: left;
            }

            #footer {
                position: fixed;
                left: 25px;
                bottom: 0;
            }

            #footer .page:after {
                content: counter(page);
            }

            .barcode {
                right: 0;
            }

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

            .no_decoration {
                text-decoration: none;
            }
        </style>
    </head>

    <body>
        <div id="header">
            <table width="100%">
                <tr>
                    <td width="90%">
                        <!-- Company details -->
                        <p>
                            @if ($settings['company_logo'] != null)
                                <img
                                    src="storage/{{ $settings['company_logo'] }}"
                                    alt="logo"
                                    style="max-width: 200px; max-height: 100px; margin-top: 10px"
                                />
                                <br />
                            @endif

                            <strong>{{ $settings['company_name'] }}</strong>
                            <br />
                            @if ($settings['company_address'] != null)
                                <span>{{ $settings['company_address'] }}</span>
                                <br />
                            @endif

                            @if ($settings['company_zip'] != null && $settings['company_city'] != null)
                                <span>{{ $settings['company_zip'] . ' ' . $settings['company_city'] }}</span>
                                <br />
                            @endif

                            @if ($settings['company_country'] != null)
                                <span>{{ $settings['company_country'] }}</span>
                                <br />
                            @endif

                            <br />
                            @if ($settings['company_phone'] != null)
                                <strong>{{ __('pdf.phone') }}</strong>
                                <a href="tel:{{ $settings['company_phone'] }}" class="no_decoration">{{ $settings['company_phone'] }}</a>
                                <br />
                            @endif

                            @if ($settings['company_email'] != null)
                                <strong>{{ __('pdf.email') }}</strong>
                                <a href="mailto:{{ $settings['company_email'] }}" class="no_decoration">
                                    {{ $settings['company_email'] }}
                                </a>
                                <br />
                            @endif

                            @if ($settings['company_vat'] != null)
                                <strong>{{ __('pdf.vat') }}</strong>
                                {{ $settings['company_vat'] }}
                                <br />
                            @endif
                        </p>
                    </td>
                    <!-- Barcode -->
                    @if ($settings['show_barcode_on_documents'] == true)
                        <td widht="10%">
                            <div class="barcode">
                                @yield('barcode')
                            </div>
                        </td>
                    @endif
                </tr>
            </table>
            <!-- Title -->
            <h1>
                @yield('title')
            </h1>
        </div>
        <!-- Content -->
        @yield('content')
        <!-- Footer -->
        <div id="footer">
            <p class="page"></p>
        </div>
    </body>
</html>
