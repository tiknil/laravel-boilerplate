@once
  <style>
    .wt-loading-wrap {
      z-index: 100;
    }

    [x-cloak] {
      display: none !important;
    }
  </style>

  @push('scripts')
    <script type="module">
      if (window.Livewire !== undefined) {
        Livewire.on('toast', ({toast}) => {
          window.showToast(toast.type, toast.message)
        })
      }
    </script>
  @endpush

@endonce
