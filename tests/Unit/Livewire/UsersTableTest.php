<?php

use App\Enums\UserRole;
use App\Livewire\UsersTable;
use App\Models\User;
use Livewire\Livewire;

test('it renders successfully', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(UsersTable::class)
        ->assertStatus(200);
});

test('it can search users by email', function () {
    $user = User::factory()->create(['email' => 'admin@example.com']);
    $otherUser = User::factory()->create(['email' => 'other@example.com']);

    Livewire::actingAs($user)
        ->test(UsersTable::class)
        ->set('search', 'admin')
        ->assertSee('admin@example.com')
        ->assertDontSee('other@example.com');
});

test('it can filter users by role', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin, 'email' => 'admin@example.com']);
    $user = User::factory()->create(['role' => UserRole::User, 'email' => 'user@example.com']);

    Livewire::actingAs($admin)
        ->test(UsersTable::class)
        ->set('role', UserRole::Admin->name)
        ->assertSee('admin@example.com')
        ->assertDontSee('user@example.com');
});

test('it can delete other users', function () {
    $admin = User::factory()->create();
    $otherUser = User::factory()->create();

    Livewire::actingAs($admin)
        ->test(UsersTable::class)
        ->call('deleteUser', $otherUser->id);

    expect(User::find($otherUser->id))->toBeNull();
});

test('it cannot delete itself', function () {
    $admin = User::factory()->create();

    Livewire::actingAs($admin)
        ->test(UsersTable::class)
        ->call('deleteUser', $admin->id);

    expect(User::find($admin->id))->not->toBeNull();
});
