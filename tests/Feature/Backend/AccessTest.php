<?php

use App\Models\User;

test('unauthenticated users are redirected to login', function () {
    $response = $this->get('/backend');

    $response->assertRedirect('/login');
});

test('authenticated users can access the backend', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/backend');

    $response->assertStatus(302); // It redirects to /backend/users as per web.php
    $response->assertRedirect('/backend/users');
});

test('authenticated users can access backend profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/backend/profile');

    $response->assertStatus(200);
});
