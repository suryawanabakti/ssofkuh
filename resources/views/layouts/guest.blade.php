<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SSO FKUH</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- CSS Files -->
    <link href="/assets/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/css/demo.min.css?1684106062" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/fav.ico">
    <style>
        @import url("https://rsms.me/inter/inter.css");

        :root {
            --tblr-font-sans-serif: "Inter Var", -apple-system, BlinkMacSystemFont,
                San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            --tblr-primary: #d63939;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body class="d-flex flex-column bg-white">
    <script src="/assets/js/demo-theme.min.js?1684106062"></script>
    {{ $slot }}
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="/assets/js/tabler.min.js?1684106062" defer></script>
    <script src="/assets/js/demo.min.js?1684106062" defer></script>
</body>

</html>
