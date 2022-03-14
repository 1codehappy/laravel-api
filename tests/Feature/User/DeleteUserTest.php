<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('deletes the user.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.delete');

    $employee = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->delete("/users/{$employee->uuid}");
    $response->assertStatus(204);
    $this->assertDatabaseMissing(
        'users',
        ['id' => $employee->id]
    );
});

it('can\'t delete the user.', function () {
    $user = User::factory()->create();
    $employee = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->delete("/users/{$employee->uuid}");
    $response->assertStatus(403);
});

it('doesn\'t exist.', function () {
    $user = User::factory()->create();
    $uuid = faker()->uuid;
    $response = $this->withHeaders(authHeader($user))
        ->delete("/users/{$uuid}");
    $response->assertStatus(404);
});
