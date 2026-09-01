<x-auth::page :title="__('two-factor.challenge.title')">
  <h2 class="text-center mt-2">{{ __('two-factor.challenge.title') }}</h2>

  <div class="text-center mt-3 mb-3" id="otp-mode">
    <div class="text-muted mb-3">
      {{ __('two-factor.challenge.otp_instruction') }}
    </div>
  </div>
  <div class="text-center mt-3 mb-3"
    id="recovery-mode"
    style="display: none;">
    <div class="text-muted mb-3">
      {{ __('two-factor.challenge.recovery_instruction') }}
    </div>
  </div>

  <form method="POST" action="{{ url('/two-factor-challenge') }}">
    @csrf

    <div id="otp-field">
      <div class="form-group mb-3">
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-key"></i></span>
          <input class="form-control text-center"
            id="code"
            name="code"
            type="text"
            style="letter-spacing: 0.3em; font-size: 1.2rem;"
            autofocus
            autocomplete="one-time-code"
            placeholder="123456"
            maxlength="6">
        </div>
      </div>
      @error('code')
        <div class="alert alert-danger mt-2">{{ __('two-factor.challenge.otp_error') }}</div>
      @enderror
    </div>

    <div id="recovery-field" style="display: none;">
      <div class="form-group mb-3">
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
          <input class="form-control text-center font-monospace"
            id="recovery_code"
            name="recovery_code"
            type="text"
            disabled
            autocomplete="off"
            placeholder="XXXX-XXXX-XXXX">
        </div>
      </div>

      @error('recovery_code')
        <div class="alert alert-danger mt-2">{{ __('two-factor.challenge.recovery_error') }}</div>
      @enderror
    </div>

    @error('recovery_code')
      <script>
        window.initialMode = 'recovery';
      </script>
    @enderror

    <div class="d-flex justify-content-between align-items-center mt-4">
      <a class="text-primary small"
        id="toggle-recovery"
        href="#">{{ __('two-factor.challenge.toggle_recovery') }}</a>
      <a class="text-primary small"
        id="toggle-otp"
        href="#"
        style="display: none;">{{ __('two-factor.challenge.toggle_otp') }}</a>
      <button class="btn btn-primary" type="submit">{{ __('two-factor.challenge.submit_btn') }}</button>
    </div>
  </form>

  <x-slot:scripts>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var currentMode = 'otp';
        var otpMode = document.getElementById('otp-mode');
        var recoveryMode = document.getElementById('recovery-mode');
        var otpField = document.getElementById('otp-field');
        var recoveryField = document.getElementById('recovery-field');
        var otpInput = document.getElementById('code');
        var recoveryInput = document.getElementById('recovery_code');
        var toggleRecovery = document.getElementById('toggle-recovery');
        var toggleOtp = document.getElementById('toggle-otp');

        function toggleMode(mode) {
          if (mode === currentMode) return;
          currentMode = mode;

          if (mode === 'recovery') {
            otpMode.style.display = 'none';
            otpField.style.display = 'none';
            otpInput.disabled = true;

            recoveryMode.style.display = '';
            recoveryField.style.display = '';
            recoveryInput.disabled = false;
            recoveryInput.focus();

            toggleRecovery.style.display = 'none';
            toggleOtp.style.display = '';
          } else {
            recoveryMode.style.display = 'none';
            recoveryField.style.display = 'none';
            recoveryInput.disabled = true;

            otpMode.style.display = '';
            otpField.style.display = '';
            otpInput.disabled = false;
            otpInput.focus();

            toggleOtp.style.display = 'none';
            toggleRecovery.style.display = '';
          }
        }

        toggleRecovery.addEventListener('click', function(e) {
          e.preventDefault();
          toggleMode('recovery');
        });

        toggleOtp.addEventListener('click', function(e) {
          e.preventDefault();
          toggleMode('otp');
        });

        if (window.initialMode === 'recovery') {
          toggleMode('recovery');
        }
      });
    </script>
  </x-slot:scripts>
</x-auth::page>
