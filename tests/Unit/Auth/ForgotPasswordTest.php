<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('forgot the password.', function () {
    $user = User::factory()->create();
    $dto = new EmailDto(['email' => $user->email]);
    $status = app(SendResetLink::class)->execute($dto);
    expect($status)->toBe(Password::RESET_LINK_SENT);
    expect(Cache::has($user->email))->toBeTrue();

    $this->assertDatabaseHas('password_resets', ['email' => $user->email]);
});

it('should be a valid user.', function () {
    $fakeEmail = faker()->email;
    $dto = new EmailDto(['email' => $fakeEmail]);
    Password::shouldReceive('sendResetLink')
        ->once()
        ->andReturn(Password::INVALID_USER);
    $status = app(SendResetLink::class)->execute($dto);
    expect($status)->toBe('passwords.user');
    expect(Cache::has($dto->email))->toBeFalse();

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
    expect(Cache::has($dto->email))->toBeFalse();

    $this->assertDatabaseMissing('password_resets', ['email' => $fakeEmail]);
});
