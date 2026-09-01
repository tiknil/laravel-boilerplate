@php($twoFactorEnabled = auth()->user()?->hasEnabledTwoFactorAuthentication() ?? false)

<button type="button"
  class="btn {{ $twoFactorEnabled ? 'btn-outline-primary' : 'btn-primary' }} btn-sm"
  data-bs-toggle="modal"
  data-bs-target="#two-factor-settings-modal">
  {{ $twoFactorEnabled ? __('two-factor.manage') : __('two-factor.enable') }}
</button>