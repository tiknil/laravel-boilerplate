<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Fortify;
use Livewire\Component;

class TwoFactorSettings extends Component
{
    /**
     * Render the full page layout instead of the profile card variant.
     */
    public bool $standalone = false;

    /**
     * Whether the inline password confirmation is being shown.
     */
    public bool $confirmingPassword = false;

    /**
     * The sensitive action waiting for the password confirmation.
     */
    public string $passwordTarget = '';

    public string $password = '';

    public string $code = '';

    public bool $showRecoveryCodes = false;

    public function mount(): void
    {
        // In the modal variant (used within the backend) the configuration is
        // started from a plain button, so the component opens directly on the
        // password confirmation screen.
        if (!$this->standalone && $this->status() === 'disabled') {
            $this->requestPassword('enable');
        }
    }

    public function render(): View
    {
        return view('backend.two-factor-settings', [
            'status' => $this->status(),
            'recoveryCodes' => $this->recoveryCodes(),
        ])->with($this->user()->two_factor_secret ? [
            'qrCodeSvg' => $this->user()->twoFactorQrCodeSvg(),
            'secret' => Fortify::currentEncrypter()->decrypt($this->user()->two_factor_secret),
        ] : []);
    }

    public function requestPassword(string $target): void
    {
        $this->passwordTarget = $target;
        $this->confirmingPassword = true;
    }

    public function cancelPasswordConfirmation(): void
    {
        $this->reset('password', 'passwordTarget', 'confirmingPassword');

        if (!$this->standalone && $this->status() === 'disabled') {
            $this->requestPassword('enable');
            $this->dispatch('close-two-factor-modal');
        }
    }

    public function submitPassword(): void
    {
        $this->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $this->user();

        match ($this->passwordTarget) {
            'enable' => app(EnableTwoFactorAuthentication::class)($user),
            'disable' => app(DisableTwoFactorAuthentication::class)($user),
            'regenerate' => app(GenerateNewRecoveryCodes::class)($user),
            default => null,
        };

        $this->reset('password', 'passwordTarget', 'confirmingPassword');

        // Let the surrounding page (e.g. the plain trigger button on the
        // profile card) know that the 2FA state changed.
        $this->dispatch('two-factor-changed');

        if (!$this->standalone && $this->status() === 'disabled') {
            $this->requestPassword('enable');
        }
    }

    public function cancelPending(): void
    {
        app(DisableTwoFactorAuthentication::class)($this->user());

        $this->reset('code');
        $this->dispatch('close-two-factor-modal');
    }

    public function confirmCode(): void
    {
        $this->validate([
            'code' => ['required', 'string', 'max:6'],
        ]);

        try {
            app(ConfirmTwoFactorAuthentication::class)($this->user(), $this->code);
        } catch (ValidationException) {
            $this->addError('code', __('two-factor.settings.code_invalid'));
            $this->reset('code');

            return;
        }

        $this->reset('code');
        $this->dispatch('two-factor-changed');
    }

    public function toggleRecoveryCodes(): void
    {
        $this->showRecoveryCodes = !$this->showRecoveryCodes;
    }

    private function user(): ?User
    {
        return auth()->user();
    }

    private function status(): string
    {
        $user = $this->user();

        if ($user->hasEnabledTwoFactorAuthentication()) {
            return 'enabled';
        }

        if ($user->two_factor_secret) {
            return 'pending';
        }

        return 'disabled';
    }

    private function recoveryCodes(): array
    {
        $codes = $this->user()->two_factor_recovery_codes;

        if (!$codes) {
            return [];
        }

        return json_decode(Fortify::currentEncrypter()->decrypt($codes), true) ?: [];
    }
}
