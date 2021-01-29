<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
</head>
<body>
<video controls autoplay onerror="location.href = this.src" src="{{ $evidenceUrl }}"></video>
<div class="text-center mt-2 mb-3">
    <a class="btn btn-primary" href="{{ $evidenceUrl }}">Download</a>
</div>
</body>
</html>
