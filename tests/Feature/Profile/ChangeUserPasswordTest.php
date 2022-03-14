<?php

use App\Domain\User\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('changes the user\'s password.', function () {
    $user = User::factory()->create(['password' => bcrypt('secret1234')]);
    $response = $this->withHeaders(authHeader($user))
        ->put(
            '/auth/me/password',
            [
                'password' => '123456789qq',
                'password_confirmation' => '123456789qq',
            ]
        );
    $response->assertStatus(200);
    $this->assertTrue(
        app(Hasher::class)->check('123456789qq', $user->fresh()->password)
    );
});

it('validates payload when changing the user\'s password', function (array $payload) {
    $user = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->put('/auth/me/password', $payload);
    $response->assertStatus(422);
})->with('password-payloads');
