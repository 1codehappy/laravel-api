<?php

use App\Domain\Permission\Models\Role;
use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('deletes the role.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('roles.delete');

    $role = Role::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->delete("/roles/{$role->uuid}");
    $response->assertStatus(204);
    $this->assertDatabaseMissing(
        'roles',
        ['id' => $role->id]
    );
});

it('can\'t delete the role.', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->delete("/roles/{$role->uuid}");
    $response->assertStatus(403);
});

it('doesn\'t exist.', function () {
    $user = User::factory()->create();
    $uuid = faker()->uuid;
    $response = $this->withHeaders(authHeader($user))
        ->delete("/roles/{$uuid}");
    $response->assertStatus(404);
});
