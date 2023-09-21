<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
       <style>
            * {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            }

            a,
            a:hover,
            a:visited {
            color: #0072af;
            text-decoration: underline;
            }

            a:hover {
            text-decoration: none;
            }

            body {
            background-color: #ffffff;
            color: #000000;
            margin: 0;
            padding: 0;
            }
       </style>
    </head>

    <body>
        @yield('content')
    </body>
</html>