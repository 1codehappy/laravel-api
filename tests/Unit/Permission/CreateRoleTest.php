<?php

use App\Domain\Permission\Actions\CreateRole;
use App\Support\Permission\DTOs\RoleDto;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('creates a new role.', function () {
    $action = new CreateRole();
    $dto = new RoleDto(['name' => faker()->name]);
    $role = $action->execute($dto);
    expect($role->name)->toBe($dto->name);
});
