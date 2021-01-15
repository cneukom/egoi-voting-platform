<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <script src="{{ asset('js/app.js') }}" async></script>
</head>
<body>
<div class="navbar navbar-light bg-light sticky-top mb-5">
    <div class="container">
        <a class="navbar-brand" href="">
            <img class="logo" alt="{{ __('app.name') }}" src="{{ asset('images/logo.svg') }}"/>
        </a>
    </div>
</div>
<div class="container">
    @yield('content')
</div>
</body>
</html>
