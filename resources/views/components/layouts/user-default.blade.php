<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- ✅ Meta title + description (SEO) --}}
    @if (!empty($metatags))
        {{ $metatags }}
    @else
        <title>Banglz</title>
    @endif

    <x-includes.user.header />

    @if (config('services.yotpo.app_key'))
        <script async src="https://staticw2.yotpo.com/{{ config('services.yotpo.app_key') }}/widget.js"></script>
    @endif

    {{ $insertstyle ?? '' }}
</head>

<body>
    <x-includes.user.navbar />
    {{ $content ?? '' }}
    <x-includes.user.footer />
    
    <!-- Chatbot Component -->
    <x-chatbot />
    
    {{ $insertjavascript ?? '' }}
</body>

</html>
