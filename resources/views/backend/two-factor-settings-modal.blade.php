<x-backend::components.modal
  id="two-factor-settings-modal"
  :title="__('two-factor.settings.modal_title')"
  :static="true">
  <livewire:two-factor-settings />
</x-backend::components.modal>

<script type="module">
  document.addEventListener('livewire:init', () => {
    let twoFactorChanged = false;

    const modal = document.getElementById('two-factor-settings-modal');

    window.Livewire.on('two-factor-changed', () => {
      twoFactorChanged = true;
    });

    window.Livewire.on('close-two-factor-modal', () => {
      bootstrap.Modal.getInstance(modal)?.hide();
    });

    modal.addEventListener('show.bs.modal', () => {
      twoFactorChanged = false;
    });

    modal.addEventListener('hidden.bs.modal', () => {
      if (twoFactorChanged) {
        location.reload();
      }
    });
  });
</script>