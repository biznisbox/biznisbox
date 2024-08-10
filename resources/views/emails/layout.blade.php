<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style media="all" type="text/css">
            .body,
            body {
                background-color: #f4f5f6;
            }
            body,
            p,
            table td {
                font-family: Helvetica, sans-serif;
            }
            .btn a,
            .btn table td {
                background-color: #fff;
            }
            .btn,
            .btn a,
            .content,
            .wrapper {
                box-sizing: border-box;
            }
            .btn a,
            body {
                font-size: 16px;
                margin: 0;
            }
            .align-center,
            .btn table td,
            .footer {
                text-align: center;
            }
            .clear,
            .footer {
                clear: both;
            }
            .btn a,
            .powered-by a {
                text-decoration: none;
            }
            body {
                -webkit-font-smoothing: antialiased;
                line-height: 1.3;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                padding: 0;
            }
            table {
                border-collapse: separate;
                mso-table-lspace: 0;
                mso-table-rspace: 0;
                width: 100%;
            }
            table td {
                font-size: 16px;
                vertical-align: top;
            }
            .body {
                width: 100%;
            }
            .container {
                margin: 0 auto !important;
                max-width: 600px;
                padding: 24px 0 0;
                width: 600px;
            }
            .btn,
            .footer,
            .main {
                width: 100%;
            }
            .content {
                display: block;
                margin: 0 auto;
                max-width: 600px;
                padding: 0;
            }
            .main {
                background: #fff;
                border: 1px solid #eaebed;
                border-radius: 16px;
            }
            .wrapper {
                padding: 24px;
            }
            .footer {
                padding-top: 24px;
            }
            .footer a,
            .footer p,
            .footer span,
            .footer td {
                color: #9a9ea6;
                font-size: 16px;
                text-align: center;
            }
            .btn a,
            a {
                color: #0867ec;
            }
            p {
                font-size: 16px;
                font-weight: 400;
                margin: 0 0 16px;
            }
            a {
                text-decoration: underline;
            }
            .btn {
                min-width: 100% !important;
            }
            .btn > tbody > tr > td {
                padding-bottom: 16px;
            }
            .btn table {
                width: auto;
            }
            .btn table td {
                border-radius: 4px;
            }
            .btn a {
                border: 2px solid #0867ec;
                border-radius: 4px;
                cursor: pointer;
                display: inline-block;
                font-weight: 700;
                padding: 12px 24px;
                text-transform: capitalize;
            }
            .btn-primary a,
            .btn-primary table td {
                background-color: #0867ec;
            }
            .btn-primary a {
                border-color: #0867ec;
                color: #fff;
            }
            .last,
            .mb0 {
                margin-bottom: 0;
            }
            .first,
            .mt0 {
                margin-top: 0;
            }
            .align-right {
                text-align: right;
            }
            .align-left {
                text-align: left;
            }
            .text-link {
                color: #0867ec !important;
                text-decoration: underline !important;
            }
            .preheader {
                color: transparent;
                display: none;
                height: 0;
                max-height: 0;
                max-width: 0;
                opacity: 0;
                overflow: hidden;
                mso-hide: all;
                visibility: hidden;
                width: 0;
            }
            @media only screen and (max-width: 640px) {
                .btn a,
                .main p,
                .main span,
                .main td {
                    font-size: 16px !important;
                }
                .btn a,
                .btn table {
                    max-width: 100% !important;
                    width: 100% !important;
                }
                .btn a,
                .btn table,
                .container {
                    width: 100% !important;
                }
                .wrapper {
                    padding: 8px !important;
                }
                .content {
                    padding: 0 !important;
                }
                .container {
                    padding: 8px 0 0 !important;
                }
                .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important;
                }
            }
            @media all {
                .btn-primary a:hover,
                .btn-primary table td:hover {
                    background-color: #086fec !important;
                }
                .btn-primary a:hover {
                    border-color: #086fec !important;
                }
                .ExternalClass {
                    width: 100%;
                }
                .ExternalClass,
                .ExternalClass div,
                .ExternalClass font,
                .ExternalClass p,
                .ExternalClass span,
                .ExternalClass td {
                    line-height: 100%;
                }
                .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important;
                }
                #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                }
            }
        </style>
    </head>

    <body>
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
            <tr>
                <td>&nbsp;</td>
                <td class="container">
                    <div class="content">
                        <span class="preheader"></span>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td class="wrapper">
                                    @yield('content')
                                </td>
                            </tr>
                        </table>
                        <div class="footer">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block">
                                        <span class="apple-link">{{ settings('company_name') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">{{ __('email.all_rights_reserved') }} &copy; {{ date('Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </body>
</html>
