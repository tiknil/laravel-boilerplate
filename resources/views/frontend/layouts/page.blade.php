<!doctype html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>
    @if(isset($title))
      {{ $title }} |
    @endif {{ config('app.name') }}
  </title>

  @vite(['resources/css/frontend/main.scss', 'resources/js/frontend/main.ts'])

  {{-- Add custom styles here using a slot: <x-slot:styles>...</x-slot:styles> --}}
  {{ $styles ?? ''}}

</head>
<body>
<x-frontend::layouts.header />

{{-- Aggiungere eventuali headers o componenti generali --}}
<div id="container">
  {{ $slot }}
</div>

<x-frontend::layouts.footer />

{{-- Add custom scripts here using a slot: <x-slot:scripts>...</x-slot:scripts> --}}
{{ $scripts ?? ''}}
</body>
</html>
