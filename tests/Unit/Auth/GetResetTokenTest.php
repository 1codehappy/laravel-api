<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it("gets the last reset token.", function () {
    $user = User::factory()->create();
    $dto = new EmailDto(['email' => $user->email]);
    app(SendResetLink::class)->execute($dto);
    $resetTokenDto = app(GetResetToken::class)->execute($dto);
    expect($resetTokenDto->email)->toBe($user->email);

    $this->assertDatabaseHas('password_resets', ['email' => $user->email]);
});

it("can't get the reset token.", function () {
    $user = User::factory()->create();
    $dto = new EmailDto(['email' => $user->email]);
    app(GetResetToken::class)->execute($dto);
})->throws(TypeError::class);

it('should be a valid user.', function () {
    $fakeEmail = faker()->email;
    $dto = new EmailDto(['email' => $fakeEmail]);
    Password::shouldReceive('sendResetLink')
        ->once()
        ->andReturn(Password::INVALID_USER);
    $status = app(SendResetLink::class)->execute($dto);
    expect($status)->toBe('passwords.user');

    $this->assertDatabaseMissing('password_resets', ['email' => $fakeEmail]);
});

it('calls the action many times.', function () {
    $fakeEmail = faker()->email;
    $dto = new EmailDto(['email' => $fakeEmail]);
    Password::shouldReceive('sendResetLink')
        ->once()
        ->andReturn(Password::RESET_THROTTLED);
    $status = app(SendResetLink::class)->execute($dto);
    expect($status)->toBe('passwords.throttled');

    $this->assertDatabaseMissing('password_resets', ['email' => $fakeEmail]);
});
