<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title')</title>
    <meta name="google-signin-client_id"
        content="692270677257-92esjppevbud8m6d532blq7qmsc2mi9a.apps.googleusercontent.com">
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50" x-init="initFlowbite();">
    @if (str_contains(request()->url(), 'dashboard'))
        @include('components.layouts.nav')
    @endif
    {{ $slot }}
    @stack('scripts')
</body>

</html>
