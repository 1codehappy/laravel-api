<?php

use App\Domain\Permission\Actions\EditRole;
use App\Domain\Permission\Models\Role;
use App\Support\Permission\DTOs\RoleDto;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('edits role data.', function () {
    $action = new EditRole();
    $dto = new RoleDto(['name' => faker()->name]);
    $role = Role::factory()->create();
    $updatedRole = $action->execute($dto, $role);
    expect($updatedRole->name)->toBe($dto->name);
});
