<div>
  @if ($confirmingPassword)
    <form wire:submit="submitPassword">
      <div class="form-group mb-3">
        <label class="form-label" for="settings-password">{{ __('two-factor.password_confirm.label') }}</label>
        <input class="form-control"
          id="settings-password"
          type="password"
          wire:model="password"
          autocomplete="current-password"
          autofocus />
        @error('password')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-primary" type="submit">{{ __('two-factor.confirm') }}</button>
        <button class="btn btn-secondary"
          type="button"
          wire:click="cancelPasswordConfirmation">{{ __('two-factor.cancel') }}</button>
      </div>
    </form>
  @elseif ($status === 'disabled')
    @if ($standalone)
      <div class="text-muted mb-3">
        {!! nl2br(__('two-factor.settings.security_notice')) !!}
      </div>

      <div class="row">
        <div class="col-auto">
          <button class="btn btn-primary"
            type="button"
            wire:click="requestPassword('enable')">
            {{ __('two-factor.enable') }}
          </button>
        </div>

        <div class="col text-end">
          <a class="btn btn-secondary"
            href="{{ route('auth.logout') }}"
            onclick="return confirm('{{ __('backend.logout_confirm') }}')">{{ __('two-factor.logout') }}</a>
        </div>
      </div>
    @endif
  @elseif ($status === 'pending')
    <div class="text-muted mb-3">
      {{ __('two-factor.settings.qr_instruction') }}
    </div>

    <div class="text-center mt-3 mb-3">
      <div class="d-inline-block p-3 bg-light border rounded">
        {!! $qrCodeSvg !!}
      </div>
    </div>

    <p class="text-muted small mb-2">
      {{ __('two-factor.settings.manual_key') }} <code>{{ $secret }}</code>
    </p>

    <form class="mt-4" wire:submit="confirmCode">
      <div class="form-group mb-3">
        <label class="form-label" for="code">
          {{ __('two-factor.settings.code_instruction') }}
        </label>
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-key"></i></span>
          <input class="form-control text-center"
            id="code"
            type="text"
            style="letter-spacing: 0.3em; font-size: 1.2rem;"
            wire:model="code"
            required
            autofocus
            autocomplete="one-time-code"
            placeholder="123456"
            maxlength="6">
        </div>
        @error('code')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-primary" type="submit">{{ __('two-factor.confirm') }}</button>
        <button class="btn btn-secondary"
          type="button"
          wire:click="cancelPending">
          {{ __('two-factor.cancel') }}
        </button>
      </div>
    </form>
  @elseif ($status === 'enabled')
    <div class="alert alert-success mt-2">
      {{ __('two-factor.settings.success_message') }}
    </div>

    <button class="btn btn-danger btn-sm"
      type="button"
      wire:click="requestPassword('disable')"
      wire:confirm="{{ __('two-factor.settings.disable_confirm') }}">
      {{ __('two-factor.disable') }}
    </button>

    <hr>

    <p class="mb-2"><b>{{ __('two-factor.settings.recovery_codes') }}</b></p>
    <p class="text-muted small mb-2">
      {{ __('two-factor.settings.recovery_desc') }}
    </p>

    @if ($showRecoveryCodes)
      <div class="bg-light p-3 rounded font-monospace small mb-2">
        <div class="row">
          @foreach ($recoveryCodes as $code)
            <div class="col-6 mb-1">{{ $code }}</div>
          @endforeach
        </div>
      </div>
    @endif

    <div class="d-flex gap-2 mt-2">
      <button class="btn btn-outline-secondary btn-sm"
        type="button"
        wire:click="toggleRecoveryCodes">
        {{ $showRecoveryCodes ? __('two-factor.settings.hide_codes') : __('two-factor.settings.show_codes') }}
      </button>

      <button class="btn btn-primary btn-sm"
        type="button"
        wire:click="requestPassword('regenerate')"
        wire:confirm="{{ __('two-factor.settings.regenerate_confirm') }}">
        {{ __('two-factor.settings.regenerate_codes') }}
      </button>
    </div>

    @if ($standalone)
      <div class="mt-4">
        <a class="btn btn-primary" href="{{ route('backend.users') }}">{{ __('two-factor.backend_access') }}</a>
      </div>
    @endif
  @endif
</div>
