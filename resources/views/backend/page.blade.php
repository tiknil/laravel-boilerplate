<!doctype html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> @yield('title') | {{ config('app.name') }}</title>

  @vite(['resources/css/backend/main.scss', 'resources/js/backend/main.ts'])
  @stack('styles')
</head>
<body>

@include('backend.components.sidebar')
<div class="wrapper d-flex flex-column min-vh-100 bg-light">

  @include('backend.components.header')

  <div class="body flex-grow-1 px-3 @yield('page-class')" id="@yield('page-id')">

    @include('backend.components.alerts')

    @yield('content')
  </div>
</div>

<div id="toastes" class="toast-container p-3 mt-5 position-fixed top-0 end-0"></div>

<script>
  window.TOASTS = {!! json_encode(\App\Utils\Toast::all()) !!}
</script>
@stack('scripts')
</body>
</html>
