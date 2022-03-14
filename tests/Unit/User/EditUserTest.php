<?php

use App\Domain\User\Actions\EditUser;
use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('edits user\'s data.', function () {
    $action = new EditUser();
    $dto = new UserDto(['name' => faker()->name, 'email' => faker()->email]);
    $user = User::factory()->create();
    $updatedUser = $action->execute($dto, $user);
    expect($updatedUser->name)->toBe($dto->name);
    expect($updatedUser->email)->toBe($dto->email);
});

it('can\'t edit the user\'s password.', function () {
    $action = new EditUser();
    $dto = new UserDto(['name' => faker()->name, 'password' => 'secret1234']);
    $user = User::factory()->create();
    $updatedUser = $action->execute($dto, $user);
    expect($updatedUser->name)->toBe($dto->name);
    expect($updatedUser->password)->not->toBe($dto->email);
});
