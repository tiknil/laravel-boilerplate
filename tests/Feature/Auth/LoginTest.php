<?php

use App\Models\User;

test('login page is displayed', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('login');
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/backend');
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('two factor challenge page renders the recovery code toggle', function () {
    $user = User::factory()->create();

    $response = $this->withSession([
        'login.id' => $user->getAuthIdentifier(),
    ])->get('/two-factor-challenge');

    $response->assertStatus(200);
    $response->assertSee('toggle-recovery');
    $response->assertSee('DOMContentLoaded');
});
