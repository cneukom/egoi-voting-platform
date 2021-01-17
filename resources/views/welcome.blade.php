<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('app.name') }}</title>
    <style>
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        div {
            background: no-repeat center center url('{{ asset('images/logo.svg') }}');
            background-size: contain;
            margin: 0 5%;
            height: 100%;
            width: 80%;
        }

        @media screen and (min-width: 600px) {
            div {
                margin: 0 15%;
                width: 70%;
            }
        }
    </style>
</head>
<body>
<div></div>
</body>
</html>
