<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('logs the user in.', function () {
    $user = User::factory()->create();
    $dto = new LoginDto(['email' => $user->email, 'password' => 'password']);
    $jwtToken = app(Login::class)->execute($dto);
    expect($jwtToken)->toBeString();
});

it("can't log the user in.", function () {
    $dto = new LoginDto(['email' => faker()->email, 'password' => 'password']);
    $jwtToken = app(Login::class)->execute($dto);
    expect($jwtToken)->toBe('');
});
