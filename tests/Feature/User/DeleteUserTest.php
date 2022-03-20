<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('deletes the user.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.delete');

    $employee = User::factory()->create();
    $this->withToken(Auth::login($user))
        ->json('DELETE', "/users/{$employee->uuid}")
        ->assertStatus(204);

    $this->assertDatabaseMissing('users', ['id' => $employee->id]);
});

it('can\'t delete the user.', function () {
    $user = User::factory()->create();
    $employee = User::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('DELETE', "/users/{$employee->uuid}")
        ->assertStatus(403);
});

it('doesn\'t exist.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('users.delete');
    $uuid = faker()->uuid;

    $this->withToken(Auth::login($user))
        ->json('DELETE', "/users/{$uuid}")
        ->assertStatus(404);
});
