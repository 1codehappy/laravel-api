<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('deletes the role.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.delete');

    $role = Role::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('DELETE', "/roles/{$role->uuid}")
        ->assertStatus(204);
    $this->assertDatabaseMissing('roles', ['id' => $role->id]);
});

it('can\'t delete the role.', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();
    $this->withToken(Auth::login($user))
        ->json('DELETE', "/roles/{$role->uuid}")
        ->assertStatus(403);
});

it('doesn\'t exist.', function () {
    $user = User::factory()->create();
    $uuid = faker()->uuid;
    $response = $this->withToken(Auth::login($user))
        ->json('DELETE', "/roles/{$uuid}")
        ->assertStatus(404);
});
