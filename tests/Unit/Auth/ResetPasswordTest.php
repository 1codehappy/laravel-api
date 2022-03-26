<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('resets the password.', function () {
    $user = User::factory()->create();
    /** @var \App\Support\Auth\DTOs\EmailDto $emailDto */
    $emailDto = new EmailDto(['email' => $user->email]);
    app(SendResetLink::class)->execute($emailDto);
    $resetTokenDto = app(GetResetToken::class)->execute($emailDto);
    $fakePassword = faker()->password(8);
    $passwordDto = new PasswordDto([
        'token' => $resetTokenDto->token,
        'email' => $resetTokenDto->email,
        'password' => $fakePassword,
        'password_confirmation' => $fakePassword,
    ]);

    $status = app(ResetPassword::class)->execute($passwordDto);
    expect($status)->toBe(Password::PASSWORD_RESET);
    expect(Cache::has($passwordDto->email))->toBeFalse();
});

it("can't reset the password if the user is invalid.", function () {
    Password::shouldReceive('reset')
        ->once()
        ->andReturn(Password::INVALID_USER);

    $fakePassword = faker()->password(8);
    $passwordDto = new PasswordDto([
        'token' => faker()->sha256(),
        'email' => faker()->email(),
        'password' => $fakePassword,
        'password_confirmation' => $fakePassword,
    ]);
    $status = app(ResetPassword::class)->execute($passwordDto);
    expect($status)->toBe('passwords.user');
});

it("can't reset the password if the token is invalid.", function () {
    Password::shouldReceive('reset')
        ->once()
        ->andReturn(Password::INVALID_TOKEN);

    $fakePassword = faker()->password(8);
    $user = User::factory()->create();
    $passwordDto = new PasswordDto([
        'token' => faker()->sha256(),
        'email' => $user->email,
        'password' => $fakePassword,
        'password_confirmation' => $fakePassword,
    ]);
    $status = app(ResetPassword::class)->execute($passwordDto);
    expect($status)->toBe('passwords.token');
});
