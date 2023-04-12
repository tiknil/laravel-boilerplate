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

@include('backend.sidebar')
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
  @include('backend.header')

  <div class="body flex-grow-1 px-3 @yield('page-class')" id="@yield('page-id')">

    @if(Session::has('success'))
      <div class="alert alert-success mb-2">
        {{ Session::get('success') }}
      </div>
    @endif

    @if(Session::has('warning'))
      <div class="alert alert-warning mb-2">
        {{ Session::get('warning') }}
      </div>
    @endif

    @if (isset($errors) && count($errors) > 0)
      <div class="alert alert-danger mb-2">
        @foreach ($errors->all() as $error)
          {{ $error }} <br/>
        @endforeach
      </div>
    @endif

    @yield('content')
  </div>
</div>

@stack('scripts')
</body>
</html>
