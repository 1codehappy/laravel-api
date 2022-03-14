<?php

use App\Domain\User\Actions\CreateUser;
use App\Support\User\DTOs\UserDto;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('creates a new user.', function () {
    $action = new CreateUser();
    $dto = new UserDto(['name' => faker()->name, 'email' => faker()->email, 'password' => faker()->password(8)]);
    $createdUser = $action->execute($dto);
    expect($createdUser->name)->toBe($dto->name);
    expect($createdUser->email)->toBe($dto->email);
});
