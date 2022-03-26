<?php

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('changes the user\'s password.', function () {
    $user = User::factory()->create(['password' => bcrypt('secret1234')]);
    $payload = ['password' => '123456789qq', 'password_confirmation' => '123456789qq'];

    $this->withToken(Auth::login($user))
        ->json('PUT', '/auth/me/password', $payload)
        ->assertStatus(200);

    expect(app(Hasher::class)->check('123456789qq', $user->fresh()->password))->toBeTrue();
});

it('validates payload when changing the user\'s password', function (array $payload) {
    $user = User::factory()->create();
    $this->withToken(Auth::login($user))
        ->json('PUT', '/auth/me/password', $payload)
        ->assertStatus(422);
})->with('change-password-payloads');
