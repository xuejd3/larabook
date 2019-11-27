<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-white antialiased">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>@yield('title', '首页') | {{ config('app.name') }}</title>
  <meta name="keywords" content="@yield('keywords', 'doc,document,文档')" />
  <meta name="description" content="@yield('description', 'Documentation.')" />

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('vendor/larabook/images/logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('vendor/larabook/images/logo.png') }}">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('vendor/larabook/css/app.css') }}">
</head>

<body class="flex flex-col text-gray-900">
  <div id="app" class="flex flex-col flex-1 h-full">

    @include('larabook::partials.header')

    <div class="w-full max-w-screen-xl mx-auto mt-16">
      @yield('content')
    </div>
  </div>

  <script>
    var LARABOOK_DOCS_PAGE            = '{{ $page }}';
    var LARABOOK_DOCS_CURRENT_VERSION = '{{ $currentVersion }}';
    var LARABOOK_FULL_URL             = '{{ $fullUrl }}';
  </script>

  @stack('footer-prepend-script')
  <!-- Scripts -->
  <script src="{{ asset('vendor/larabook/js/app.js') }}"></script>
  @stack('footer-script')

  @include('larabook::plugins.google-analytics')
</body>

</html>
