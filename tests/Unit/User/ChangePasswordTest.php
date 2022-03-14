<?php

use App\Domain\User\Actions\ChangePassword;
use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('changes password', function () {
    $action = new ChangePassword();
    $dto = new UserDto(['password' => 'secret1234']);
    $user = User::factory()->create();
    $updatedUser = $action->execute($dto, $user);
    expect(app(Hasher::class)->check($dto->password, $updatedUser->password))
        ->toBeTrue();
});
