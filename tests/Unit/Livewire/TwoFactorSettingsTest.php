<?php

use App\Livewire\TwoFactorSettings;
use App\Models\User;
use Laravel\Fortify\Fortify;
use Livewire\Livewire;
use PragmaRX\Google2FA\Google2FA;

function twoFactorOtpFor(User $user): string
{
    $secret = Fortify::currentEncrypter()->decrypt($user->fresh()->two_factor_secret);

    return app(Google2FA::class)->getCurrentOtp($secret);
}

function seedEnabledUser(): User
{
    $user = User::factory()->create();

    $user->forceFill([
        'two_factor_secret' => encrypt('0123456789abcdef'),
        'two_factor_recovery_codes' => encrypt(json_encode([
            '11111-11111',
            '22222-22222',
        ])),
        'two_factor_confirmed_at' => now(),
    ])->save();

    return $user;
}

test('in the modal variant it asks for the password when 2FA is not configured', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(TwoFactorSettings::class)
        ->assertSee('Conferma la password');
});

test('in the standalone variant it shows the enable button', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(TwoFactorSettings::class, ['standalone' => true])
        ->assertSee('Abilita 2FA');
});

test('it does not enable 2FA with a wrong password', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(TwoFactorSettings::class)
        ->set('password', 'wrong-password')
        ->call('submitPassword')
        ->assertHasErrors(['password']);

    expect($user->fresh()->two_factor_secret)->toBeNull();
});

test('it enables 2FA with the correct password and shows the QR code', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(TwoFactorSettings::class)
        ->set('password', 'password')
        ->call('submitPassword')
        ->assertSet('confirmingPassword', false)
        ->assertSee('Scansiona il QR Code');

    $user->refresh();
    expect($user->two_factor_secret)->not->toBeNull();
    expect($user->two_factor_recovery_codes)->not->toBeNull();
});

test('it confirms the two factor code and shows the recovery codes', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(TwoFactorSettings::class)
        ->set('password', 'password')
        ->call('submitPassword')
        ->set('code', twoFactorOtpFor($user))
        ->call('confirmCode')
        ->assertHasNoErrors()
        ->assertSee('Codici di recupero');

    expect($user->fresh()->two_factor_confirmed_at)->not->toBeNull();
});

test('it rejects an invalid two factor code', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(TwoFactorSettings::class)
        ->set('password', 'password')
        ->call('submitPassword')
        ->set('code', '000000')
        ->call('confirmCode')
        ->assertHasErrors(['code']);

    expect($user->fresh()->two_factor_confirmed_at)->toBeNull();
});

test('it cancels a pending configuration directly without asking for the password', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(TwoFactorSettings::class)
        ->set('password', 'password')
        ->call('submitPassword')
        ->assertSee('Annulla')
        ->assertDontSee('Annulla configurazione')
        ->call('cancelPending')
        ->assertDispatched('two-factor-changed')
        ->assertDispatched('close-two-factor-modal')
        ->assertDontSee('Conferma la password');

    $user->refresh();
    expect($user->two_factor_secret)->toBeNull();
    expect($user->two_factor_recovery_codes)->toBeNull();
    expect($user->two_factor_confirmed_at)->toBeNull();
});

test('it disables 2FA with the correct password', function () {
    $user = seedEnabledUser();

    Livewire::actingAs($user)
        ->test(TwoFactorSettings::class)
        ->assertSee('Disabilita 2FA')
        ->call('requestPassword', 'disable')
        ->set('password', 'password')
        ->call('submitPassword')
        ->assertSee('Conferma la password');

    $user->refresh();
    expect($user->two_factor_secret)->toBeNull();
    expect($user->two_factor_confirmed_at)->toBeNull();
});

test('it regenerates the recovery codes with the correct password', function () {
    $user = seedEnabledUser();
    $before = Fortify::currentEncrypter()->decrypt($user->fresh()->two_factor_recovery_codes);

    Livewire::actingAs($user)
        ->test(TwoFactorSettings::class)
        ->call('requestPassword', 'regenerate')
        ->set('password', 'password')
        ->call('submitPassword');

    $after = Fortify::currentEncrypter()->decrypt($user->fresh()->two_factor_recovery_codes);
    expect($after)->not->toBe($before);
});

test('the dedicated setup page renders the component', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/user/two-factor-setup')
        ->assertOk()
        ->assertSee('Abilita 2FA');
});

test('the backend profile shows the plain trigger button', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/backend/profile')
        ->assertOk()
        ->assertSee('Abilita 2FA')
        ->assertSee('two-factor-settings-modal');
});
