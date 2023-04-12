<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') | {{ config('app.name') }}</title>

    @vite(['resources/css/auth/main.scss'])
    @stack('styles')
</head>
<body class="bg-secondary p-2" style="min-height: 100vh">

<div class="bg-light" id="auth-page">
    @yield('content')
</div>

@stack('scripts')
</body>
</html>
