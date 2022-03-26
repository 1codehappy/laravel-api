<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('resets the password.', function () {
    $user = User::factory()->create();
    /** @var \App\Support\Auth\DTOs\EmailDto $dto */
    $dto = new EmailDto(['email' => $user->email]);
    app(SendResetLink::class)->execute($dto);
    $stdClass = app(GetResetToken::class)->execute($dto);

    $fakePassword = faker()->password(8);
    $payload = [
        'token' => $stdClass->token,
        'email' => $stdClass->email,
        'password' => $fakePassword,
        'password_confirmation' => $fakePassword,
    ];

    $this->json('POST', '/auth/reset-password', $payload)
        ->assertStatus(201)
        ->assertJson(['message' => __('passwords.reset')]);
});
