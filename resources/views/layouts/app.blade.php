<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SSO FK UH</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <!-- CSS files -->
    <link href="/assets/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/css/demo.min.css?1684106062" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/fav.ico">
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            --tblr-primary: #d63939;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>

    <script src="/assets/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
        <!-- Navbar -->
        @include('partials.header')

        <div class="page-wrapper">
            <!-- Page header -->
            @yield('content')
            @include('partials.footer')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="/assets/js/tabler.min.js?1684106062" defer></script>
    <script src="/assets/js/demo.min.js?1684106062" defer></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script>
        function formLoading() {
            $(this).addClass("btn-loading");
        }
    </script>

    @stack('js')
</body>

</html>
