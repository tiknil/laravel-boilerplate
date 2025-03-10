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

  @vite(['resources/css/backend/main.scss', 'resources/js/backend/main.ts'])

  {{-- Add custom styles here using a slot: <x-slot:styles>...</x-slot:styles> --}}
  {{ $styles ?? ''}}

  {{ BsBladeForms::assets() }}
</head>
<body>

<x-backend::layouts.sidebar/>

<div class="wrapper d-flex flex-column min-vh-100 bg-light">

  <x-backend::layouts.header/>

  <div class="body flex-grow-1 px-3" id="{{ $pageId ?? '' }}">

    <x-backend::layouts.alerts/>

    {{ $slot }}
  </div>
</div>

<div id="toastes" class="toast-container p-3 mt-5 position-fixed top-0 end-0"></div>

<script>
  window.TOASTS = {!! json_encode(\App\Utils\Toast::all()) !!}
</script>

<script type="module">
  if (window.Livewire !== undefined) {
    Livewire.on('toast', ({toast}) => {
      window.showToast(toast.type, toast.message)
    })
  }
</script>

{{-- Add custom scripts here using a slot: <x-slot:scripts>...</x-slot:scripts> --}}
{{ $scripts ?? ''}}
</body>
</html>
